<?php

namespace NextDeveloper\IAM\Services\Registration;

use App\Grants\OneTimeEmail;
use NextDeveloper\I18n\Helpers\i18n;
use NextDeveloper\IAM\Authorization\Roles\MemberRole;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Services\AccountsService;
use NextDeveloper\IAM\Services\RolesService;
use NextDeveloper\IAM\Services\UsersService;

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

        $account = AccountsService::createAccount(i18n::t("My Account"), $user);

        $role = RolesService::createRoleFromScope(new MemberRole());
        RolesService::assignUserToRole($user, $role, $account);

        return $user;
    }

    public static function registerUserWithEmail($email) : Users
    {
        $user = UsersService::createWithEmail($email);
        return self::registerUser($user);
    }
}
