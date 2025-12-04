<?php

namespace NextDeveloper\IAM\Services\Authentication;

use NextDeveloper\IAM\Helpers\UserHelper;

class PasswordService
{
    public static function updatePassword($password) {
        $passwordGrant = new \NextDeveloper\IAM\AuthenticationGrants\Password();

        $passwordGrant->update(UserHelper::me(), $password);

        return true;
    }
}
