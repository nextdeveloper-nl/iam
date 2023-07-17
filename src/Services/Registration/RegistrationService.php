<?php

namespace NextDeveloper\Authentication\Services\Registration;

use NextDeveloper\Accounts\Database\Models\User;
use NextDeveloper\Authentication\Services\LoginMechanisms\OneTimeEmail;

class RegistrationService
{
    public static function registerUser(User $user)
    {
        $loginMechanism = new OneTimeEmail();
        $mechanism = $loginMechanism->create($user);
        $loginMechanism->generatePassword($mechanism);

    }
}