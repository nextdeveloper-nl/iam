<?php

namespace NextDeveloper\IAM\Services;

use NextDeveloper\IAM\Authorization\Roles\IAuthorizationRole;
use NextDeveloper\IAM\Database\Models\IamRole;
use NextDeveloper\IAM\Database\Models\IamUser;
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
     * This function creates IamRole with given AuthorizationRole
     *
     * @param IAuthorizationRole $role
     * @return IamRole
     * @throws \Exception
     */
    public static function createRoleFromAuthorizationScope(IAuthorizationRole $role) : IamRole
    {
        $role = IamRole::where('name', $role::NAME)->first();

        if($role) {
            return $role;
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
    public static function assignUserToRole(IamUser $user, IamRole $role) : bool
    {

    }
}