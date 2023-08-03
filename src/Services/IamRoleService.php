<?php

namespace NextDeveloper\IAM\Services;

use NextDeveloper\IAM\Authorization\Roles\IAuthorizationRole;
use NextDeveloper\IAM\Database\Models\IamAccount;
use NextDeveloper\IAM\Database\Models\IamRole;
use NextDeveloper\IAM\Database\Models\IamRoleUser;
use NextDeveloper\IAM\Database\Models\IamUser;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamRoleService;

/**
* This class is responsible from managing the data for IamRole
*
* Class IamRoleService.
*
* @package NextDeveloper\IAM\Database\Models
*/
class IamRoleService extends AbstractIamRoleService {

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    /**
     * Returns the role.
     *
     * @throws \Exception
     */
    public static function getRole(IAuthorizationRole $role) : IamRole
    {
        $iamRole = IamRole::where('name', $role::NAME)->first();

        if(!$iamRole) {
            $iamRole = IamRoleService::createRoleFromScope($role);
        }

        return $iamRole;
    }

    /**
     * This function creates IamRole with given AuthorizationRole
     *
     * @param IAuthorizationRole $role
     * @return IamRole
     * @throws \Exception
     */
    public static function createRoleFromScope(IAuthorizationRole $role) : IamRole
    {
        $iamRole = IamRole::where('name', $role::NAME)->first();

        if($iamRole) {
            return $iamRole;
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
     * @param IamUser $user
     * @param IamRole $role
     * @return bool
     */
    public static function assignUserToRole(IamUser $user, IamRole $role, IamAccount $account = null) : bool
    {
        //  No one can be a system admin
        if($role->name == 'system-admin') {
            return false;
        }

        //  Getting the roles of user
        $role = IamRoleUser::where('user_id', $user->id)
            ->where('role_id', $role->id);

        if($account) {
            $role = $role->where('account_id', $account->id);
        } else {
            $account = UserHelper::masterAccount($user);
            $role = $role->where('account_id', $account->id);
        }

        $role = $role->first();

        if($role) {
            self::setRoleAsActive($role);

            return true;
        }

        IamRoleUser::create([
            'user_id'       =>  $user->id,
            'account_id'    =>  $account->id,
            'role_id'       =>  $role->id
        ]);
        
        return true;
    }

    public static function getUserRole(IamUser $user, IamAccount $account) : IamRole
    {
        $role = $user->iamRole()
            ->wherePivot('account_id', $account->id)
            ->where('is_active', 1)
            ->orderBy('level', 'asc')
            ->first();

        //  If the user dont have any roles, we are creating the Member role for the user
        if(!$role) {
            $role = self::getRole(new MemberRole());

            self::assignUserToRole($user, $role);

            return self::getUserRole($user, $account);
        }

        return $role;
    }

    /**
     * Sets the related IamUserRole as active
     *
     * @param IamRoleUser $roleUser
     * @return IamRoleUser
     */
    public static function setRoleAsActive(IamRoleUser $roleUser) : IamRoleUser
    {
        //  Mark all other roles as not active
        $roles = IamRoleUser::where('user_id', $roleUser->user_id)
            ->where('account_id', $roleUser->account_id)
            ->update([
                'is_active' =>  0
            ]);

        //  Update the requested role as active
        IamRoleUser::where('user_id', $roleUser->user_id)
            ->where('account_id', $roleUser->account_id)
            ->where('role_id', $roleUser->role_id)
            ->update([
                'is_active' =>  1
            ]);

        //  Get the relation again
        $roleUser = IamRoleUser::where('user_id', $roleUser->user_id)
            ->where('account_id', $roleUser->account_id)
            ->where('role_id', $roleUser->role_id)
            ->first();

        return $roleUser;
    }

    public static function setRoleAsActiveById($iamRoleId, IamUser $user, IamAccount $account) : IamRoleUser
    {
        $role = IamRole::where('uuid', $iamRoleId)->first();

        //  Mark all other roles as not active
        $roles = IamRoleUser::where('user_id', $user->id)
            ->where('account_id', $account->id)
            ->update([
                'is_active' =>  0
            ]);

        //  Update the requested role as active
        $roles = IamRoleUser::where('user_id', $user->id)
            ->where('account_id', $account->id)
            ->where('role_id', $role->id)
            ->update([
                'is_active' =>  1
            ]);

        //  Get the relation again
        $roles = IamRoleUser::where('user_id', $user->id)
            ->where('account_id', $account->id)
            ->where('role_id', $role->id)
            ->first();

        return $roles;
    }
}