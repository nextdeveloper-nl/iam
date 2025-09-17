<?php

namespace NextDeveloper\IAM\Services\Registration;

use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Services\UsersService;

class RegistrationService
{
    public static function registerUserWithEmail($email) : Users
    {
        $user = UsersService::getByEmail($email);

        if($user) {
            return $user;
        }

        $user = UsersService::createWithEmail($email);

        return $user;
    }
}
