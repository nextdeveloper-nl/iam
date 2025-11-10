<?php

namespace NextDeveloper\IAM\Services\Authentication;

use App\Grants\OneTimeEmail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use NextDeveloper\IAM\AuthenticationGrants\Password;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Database\Models\OauthClients;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Exceptions\OAuthExceptions;

class OAuthService
{
    public static function createSession($clientId, $requestUri, $scope = []) :?string {
        $oauthClient = OauthClients::where('id', $clientId)
            ->where('redirect', $requestUri)
            ->first();

        if(!$oauthClient) {
            return null;
        }

        $session = Str::random(64);

        Cache::put('auth-session:' . $session, [
            'client_id' => $clientId,
            'redirect' => $requestUri,
            'scope' => $scope,
            'requires_2fa' => false,
        ], 3000);

        return $session;
    }

    public static function getLoginRequirements($session, $email)
    {

    }

    public static function loginWithEmailPassword($session, $email, $password)
    {
        $user = Users::withoutGlobalScope(AuthorizationScope::class)
            ->where('email', $email)
            ->first();

        if(!$user) {
            return OAuthExceptions::userNotFound();
        }
    }

    public static function loginWithUsernamePassword($session, $username, $password)
    {
        $sessionData = Cache::get('auth-session:' . $session);

        if(!$sessionData || !isset($sessionData['user_id'])) {
            throw OAuthExceptions::invalidSession();
        }

        $user = Users::withoutGlobalScope(AuthorizationScope::class)
            ->where('username', $username)
            ->first();

        if(!$user) {
            throw OAuthExceptions::userNotFound();
        }

        $sessionData['user_id'] = $user->id;

        $mechanism = LoginMechanisms::withoutGlobalScope(AuthorizationScope::class)
            ->where('iam_user_id', $user->id)
            ->where('login_mechanism', Password::LOGINNAME)
            ->first();

        if(!$mechanism)
            throw OAuthExceptions::mechanismNotFound();

        $isLoggedIn = (new Password())->attempt($mechanism, $password);

        $sessionData['password_login'] = $isLoggedIn;

        Cache::set('auth-session:' . $session, $sessionData, 3000);

        return $isLoggedIn;
    }

    public static function getAuthCode($session)
    {
        $sessionData = Cache::get('auth-session:' . $session);

        if(!$sessionData || !isset($sessionData['user_id'])) {
            throw OAuthExceptions::invalidSession();
        }

        if(
            (isset($sessionData['password']) && $sessionData['password'] === true) ||
            (isset($sessionData['email_otp']) && $sessionData['email_otp'] === true)
        ) {
            throw OAuthExceptions::invalidSession('User is not logged in with any logging mechanism.');
        }

        $authCode = Str::random(128);

        Cache::put('auth-code:' . $authCode, $sessionData, 3000);

        return $authCode;
    }

    public static function loginWithEmailOTP($code, $password)
    {
        $sessionData = Cache::get('auth-session:' . $session);

        if(!$sessionData || !isset($sessionData['user_id'])) {
            throw OAuthExceptions::invalidSession();
        }
    }
}
