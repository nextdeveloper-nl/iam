<?php

namespace NextDeveloper\IAM\Services\LoginMechanisms;

use Laravel\Socialite\Facades\Socialite;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Services\LoginMechanisms\AbstractLogin;
use NextDeveloper\IAM\Services\LoginMechanisms\ILoginService;

class GoogleLogin extends AbstractLogin implements ILoginService
{
    const LOGINNAME = 'GoogleLogin';

    public function create(Users $user) : LoginMechanisms
    {
        $latestMechanism = self::getLatestMechanism($user, self::LOGINNAME);

        if (!$latestMechanism) {
            $latestMechanism = LoginMechanisms::create([
                'iam_user_id'          => $user->id,
                'login_mechanism'  => self::LOGINNAME,
            ]);

            $latestMechanism->update([
                'login_data'    =>  Socialite::driver('google')->stateless()->user()
            ]);
        }

        return $latestMechanism;
    }

    public static function update(Users $user, $password) : LoginMechanisms
    {
        //  Here we will update the password hash of latest password mechanism
        //  We will be using Argos2 hash mechanism for this.
    }

    /**
     * @param Users $user
     * @param $mechanismName
     * @return LoginMechanisms
     */
    public static function getLatestMechanism(Users $user, $mechanismName = null) : ?LoginMechanisms
    {
        if(!$mechanismName)
            $mechanismName = self::LOGINNAME;

        $mechanism = parent::getLatestMechanism($user, $mechanismName);

        return $mechanism;
    }

    public function attempt(LoginMechanisms $mechanism, array $loginData): bool
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

    public function generatePassword(LoginMechanisms $mechanism): string
    {
        // TODO: Implement generatePassword() method.
    }
}