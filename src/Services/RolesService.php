<?php

namespace NextDeveloper\IAM\Services;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Authorization\Roles\IAuthorizationRole;
use NextDeveloper\IAM\Authorization\Roles\MemberRole;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Models\Roles;
use NextDeveloper\IAM\Database\Models\RoleUsers;
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
class RolesService extends AbstractRolesService {

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    /**
     * Returns the role.
     *
     * @throws \Exception
     */
    public static function getRole(IAuthorizationRole $role) : Roles
    {
        $Roles = Roles::where('name', $role::NAME)->first();

        if(!$Roles) {
            $Roles = RolesService::createRoleFromScope($role);
        }

        return $Roles;
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
    public static function assignUserToRole(Users $user, Roles $role, Accounts $account = null) : bool
    {
        //  No one can be a system admin
        if($role->name == 'system-admin') {
            return false;
        }

        //  Getting the roles of user
        $relation = RoleUsers::where('iam_user_id', $user->id)
            ->where('iam_role_id', $role->id)->first();

        if(!$account) {
            $account = UserHelper::masterAccount($user);
        }

        if(!$relation) {
            $relation = RoleUsers::create([
                'iam_user_id'       =>  $user->id,
                'iam_account_id'    =>  $account->id,
                'iam_role_id'       =>  $role->id
            ]);
        }

        self::setRoleAsActive($relation);

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
        //  Mark all other roles as not active
        $roles = RoleUsers::withoutGlobalScopes()
            ->where('iam_user_id', $roleUser->iam_user_id)
            ->where('iam_account_id', $roleUser->iam_account_id)
            ->update([
                'is_active' =>  0
            ]);

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
