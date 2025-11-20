<?php

namespace NextDeveloper\IAM\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Database\GlobalScopes\LimitScope;
use NextDeveloper\IAM\Authorization\Roles\IAuthorizationRole;
use NextDeveloper\IAM\Authorization\Roles\MemberRole;
use NextDeveloper\IAM\Database\Filters\RolesQueryFilter;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Models\Roles;
use NextDeveloper\IAM\Database\Models\RoleUsers;
use NextDeveloper\IAM\Database\Models\UserRoles;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\AbstractServices\AbstractRolesService;

/**
 * This class is responsible from managing the data for Roles
 *
 * Class RolesService.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class RolesService extends AbstractRolesService
{

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
    public static function get(RolesQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator{
        $roles = UserHelper::getRoles();

        $level = 255;

        foreach ($roles as $role) {
            if($role->level < $level) {
                $level = $role->level;
            }
        }

        $roles = Roles::withoutGlobalScope(AuthorizationScope::class)
            ->filter($filter)
            ->where('level', '>=', $level)
            ->get();

        return $roles;
    }

    /**
     * Returns the role.
     *
     * @throws \Exception
     */
    public static function getRole(IAuthorizationRole $role) : Roles
    {
        $Roles = Roles::withoutGlobalScope(AuthorizationScope::class)
            ->where('name', $role::NAME)
            ->first();

        if(!$Roles) {
            $Roles = RolesService::createRoleFromScope($role);
        }

        return $Roles;
    }

    public static function assignDefaultRoles(Users $user, Accounts $account)
    {
        foreach (config('leo.register.default_roles') as $roleName) {
            $getRole = RolesService::getRoleByName($roleName);

            if(!$getRole) {
                Log::error(__METHOD__ . ' | Applying default roles but cannot find this role; ' . $roleName);
                continue;
            }

            RolesService::assignUserToRole($user, $getRole, $account);
        }
    }

    /**
     * Returns the role if it exists in database. If not returns null.
     *
     * @param string $role
     * @return Roles
     */
    public static function getRoleByName(string $role) : ?Roles
    {
        return Roles::withoutGlobalScope(AuthorizationScope::class)
            ->whereLike('name', $role)
            ->first();
    }

    /**
     * Returns the roles of the user
     *
     * @param Users $user
     * @param Accounts $account
     * @return array
     */
    public static function getUserRoles($user, $account) :?Collection
    {
        if(!$account)
            return null;

        $roles = UserRoles::withoutGlobalScope(AuthorizationScope::class)
            // Here we have limits scope because if a user has more than 20 roles,
            // then some of them are not put into account
            ->withoutGlobalScope(LimitScope::class)
            ->where('iam_user_id', $user->id)
            ->where('iam_account_id', $account->id)
            ->where('is_active', true)
            ->orderBy('level', 'asc')
            ->get();

        return $roles;
    }

    /**
     * This function creates Roles with given AuthorizationRole
     *
     * @param IAuthorizationRole $role
     * @return Roles
     * @throws \Exception
     */
    public static function createRoleFromScope(IAuthorizationRole $role) : Roles
    {
        $Roles = Roles::where('name', $role::NAME)->first();

        if($Roles) {
            return $Roles;
        }

        $data = [
            'name'  =>  $role::NAME,
            'class' =>  get_class($role),
            'level' =>  $role::LEVEL
        ];

        return parent::create($data);
    }

    /**
     * Assigns user to role
     *
     * @param Users $user
     * @param Roles $role
     * @return bool
     */
    public static function assignUserToRole(Users $user, Roles $role, Accounts $account = null, $isRoleActive = null) : bool
    {
        //  No one can be a system admin
        if($role->name == 'system-admin') {
            return false;
        }

        if(!$account) {
            $account = UserHelper::currentAccount();
        }

        //  Getting the roles of user
        $relation = RoleUsers::withoutGlobalScopes()
            ->where('iam_user_id', $user->id)
            ->where('iam_role_id', $role->id)
            ->where('iam_account_id', $account->id)
            ->first();

        $isActive = true;

        if($isRoleActive !== null) {
            $isActive = $isRoleActive;
        }

        if(!$relation) {
            $relation = RoleUsers::create([
                'iam_user_id'       =>  $user->id,
                'iam_account_id'    =>  $account->id,
                'iam_role_id'       =>  $role->id,
                'is_active'         =>  $isActive
            ]);
        }

        if($isActive) self::setRoleAsActive($relation);

        return true;
    }

    public static function getUserRole(Users $user, Accounts $account) : Roles
    {
        $role = Cache::get(
            CacheHelper::getKey('Users', $user->uuid, 'CurrentRole')
        );

        if($role) {
            return $role;
        }

        $userRoleRelation = RoleUsers::withoutGlobalScope(AuthorizationScope::class)
            ->where('iam_user_id', $user->id)
            ->where('is_active', 1)
            ->first();

        if(!$userRoleRelation) {
            $role = self::getRole(new MemberRole());

            self::assignUserToRole($user, $role);
        }

        $role = Roles::withoutGlobalScope(AuthorizationScope::class)
            ->where('id', $userRoleRelation->iam_role_id)
            ->first();

        //  If the user don't have any roles, we are creating the Member role for the user
        if(!$role) {
            $role = self::getRole(new MemberRole());

            self::assignUserToRole($user, $role);

            return self::getUserRole($user, $account);
        }

        Cache::set(
            CacheHelper::getKey('Users', $user->uuid, 'CurrentRole'),
            $role
        );

        return $role;
    }

    /**
     * Sets the related UsersRole as active
     *
     * @param RoleUsers $roleUser
     * @return RoleUsers
     */
    public static function setRoleAsActive(RoleUsers $roleUser) : RoleUsers
    {
        /**
         * Here design has changed because we are actively looking for all roles while making security checks.
         * That is why we are not deactivating roles here.
         */

        //  Mark all other roles as not active
//        $roles = RoleUsers::withoutGlobalScopes()
//            ->where('iam_user_id', $roleUser->iam_user_id)
//            ->where('iam_account_id', $roleUser->iam_account_id)
//            ->update([
//                'is_active' =>  0
//            ]);

        //  Update the requested role as active
        RoleUsers::withoutGlobalScopes()
            ->where('iam_user_id', $roleUser->iam_user_id)
            ->where('iam_account_id', $roleUser->iam_account_id)
            ->where('iam_role_id', $roleUser->iam_role_id)
            ->update([
                'is_active' =>  1
            ]);

        //  Get the relation again
        $roleUser = RoleUsers::withoutGlobalScopes()
            ->where('iam_user_id', $roleUser->iam_user_id)
            ->where('iam_account_id', $roleUser->iam_account_id)
            ->where('iam_role_id', $roleUser->iam_role_id)
            ->first();

        return $roleUser;
    }

    public static function setRoleAsActiveById($RolesId, Users $user, Accounts $account) : RoleUsers
    {
        $role = Roles::where('uuid', $RolesId)->first();

        //  Mark all other roles as not active
        $roles = RoleUsers::where('iam_user_id', $user->id)
            ->where('iam_account_id', $account->id)
            ->update([
                'is_active' =>  0
            ]);

        //  Update the requested role as active
        $roles = RoleUsers::where('iam_user_id', $user->id)
            ->where('iam_account_id', $account->id)
            ->where('iam_role_id', $role->id)
            ->update([
                'is_active' =>  1
            ]);

        //  Get the relation again
        $roles = RoleUsers::where('iam_user_id', $user->id)
            ->where('iam_account_id', $account->id)
            ->where('iam_role_id', $role->id)
            ->first();

        return $roles;
    }
}
