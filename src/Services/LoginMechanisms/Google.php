<?php

namespace NextDeveloper\Authentication\Services\OAuth2\LoginMechanisms;

use NextDeveloper\IAM\Database\Models\IamLoginMechanism;
use NextDeveloper\IAM\Database\Models\IamUser;
use NextDeveloper\IAM\Services\LoginMechanisms\AbstractLogin;
use NextDeveloper\IAM\Services\LoginMechanisms\ILoginService;

class Google extends AbstractLogin implements ILoginService
{
    const LOGINNAME = 'QR';

    public static function create(IamUser $user) : IamLoginMechanism
    {
        //  We will create a password login mechanism
    }

    public static function update(IamUser $user, $password) : IamLoginMechanism
    {
        //  Here we will update the password hash of latest password mechanism
        //  We will be using Argos2 hash mechanism for this.
    }

    public static function getLatestMechanism(IamUser $user) : IamLoginMechanism
    {
        //  Here we return the latest Password mechanism
    }

    public function attempt()
    {
        // TODO: Implement attempt() method.
    }

    /**
     * Returns the identifier of the grant
     *
     * @return string grant type
     */
    public function getIdentifier()
    {
        return 'password';
    }

    public function generatePassword(IamLoginMechanism $mechanism): string
    {
        // TODO: Implement generatePassword() method.
    }
}