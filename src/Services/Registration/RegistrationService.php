<?php

namespace NextDeveloper\IAM\Services\Registration;

use App\Actions\IAM\Users\FixRoles;
use App\Grants\OneTimeEmail;
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
