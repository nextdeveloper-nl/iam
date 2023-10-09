<?php

namespace NextDeveloper\IAM\Services\Registration;

use NextDeveloper\IAM\Authorization\Roles\MemberRole;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Services\RolesService;
use NextDeveloper\IAM\Services\LoginMechanisms\OneTimeEmail;

class RegistrationService
{
    /**
     * This function will register the user to the system. Which means it will create the first default login
     * mechanism for the user, so that the user can login.
     *
     * @param Users $user
     * @return Users
     */
    public static function registerUser(Users $user) : Users
    {
        $loginMechanism = new OneTimeEmail();
        $mechanism = $loginMechanism->create($user);
        $loginMechanism->generatePassword($mechanism);

        $role = RolesService::createRoleFromScope(new MemberRole());
        $result = RolesService::assignUserToRole($user, $role);

        return $user;
    }
}
