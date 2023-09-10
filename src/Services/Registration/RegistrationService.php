<?php

namespace NextDeveloper\IAM\Services\Registration;

use NextDeveloper\IAM\Authorization\Roles\MemberRole;
use NextDeveloper\IAM\Database\Models\IamUser;
use NextDeveloper\IAM\Services\IamRoleService;
use NextDeveloper\IAM\Services\LoginMechanisms\OneTimeEmail;

class RegistrationService
{
    /**
     * This function will register the user to the system. Which means it will create the first default login
     * mechanism for the user, so that the user can login.
     *
     * @param IamUser $user
     * @return IamUser
     */
    public static function registerUser(IamUser $user) : IamUser
    {
        $loginMechanism = new OneTimeEmail();
        $mechanism = $loginMechanism->create($user);
        $loginMechanism->generatePassword($mechanism);

        $role = RolesService::createRoleFromScope(new MemberRole());
        $result = RolesService::assignUserToRole($user, $role);

        return $user;
    }
}