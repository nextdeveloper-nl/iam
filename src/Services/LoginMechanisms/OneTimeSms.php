<?php

namespace NextDeveloper\Authentication\Services\OAuth2\LoginMechanisms;

use NextDeveloper\Accounts\Database\Models\User;
use NextDeveloper\Authentication\Database\Models\AuthenticationLoginMechanism;

class OneTimeSms implements ILoginService
{
    public function attempt(AuthenticationLoginMechanism $mechanism, array $loginData)
    {
        // TODO: Implement attempt() method.
    }

    public function generatePassword(AuthenticationLoginMechanism $mechanism)
    {
        // TODO: Implement generatePassword() method.
    }

    public function create(User $user): AuthenticationLoginMechanism
    {
        // TODO: Implement create() method.
    }
}