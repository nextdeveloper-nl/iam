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
        //  Getting the roles of user
        $isExists = IamRoleUser::where('user_id', $user->id)
            ->where('role_id', $role->id);

        if($account) {
            $isExists = $isExists->where('account_id', $account->id);
        } else {
            $account = UserHelper::masterAccount($user);
        }

        try {
            IamRoleUser::create([
                'user_id'       =>  $user->id,
                'account_id'    =>  $account->id,
                'role_id'       =>  $role->id
            ]);
        } catch (\Exception $e) {
            if($e->getCode() == 23000) {
                //  We discard this because it means this relation is already exists.
                return true;
            }
        }
        
        return true;
    }
}