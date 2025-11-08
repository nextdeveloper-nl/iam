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
    public static function createSession($clientId, $clientSecret, $requestUri) :?string {
        $oauthClient = OauthClients::where('id', $clientId)
            ->where('secret', $clientSecret)
            ->where('redirect', $requestUri)
            ->first();

        if(!$oauthClient) {
            return null;
        }

        $randomCode = Str::random(64);

        Cache::put('auth-session:' . $randomCode, [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect' => $requestUri,
        ], 3000);

        return $randomCode;
    }

    public static function loginWithEmailPassword($code, $email, $password)
    {
        $user = Users::withoutGlobalScope(AuthorizationScope::class)
            ->where('email', $email)
            ->first();

        if(!$user) {
            return OAuthExceptions::userNotFound();
        }
    }

    public static function loginWithUsernamePassword($code, $username, $password)
    {
        $session = Cache::get('auth-session:' . $code);

        $user = Users::withoutGlobalScope(AuthorizationScope::class)
            ->where('username', $username)
            ->first();

        if(!$user) {
            throw OAuthExceptions::userNotFound();
        }

        $mechanism = LoginMechanisms::withoutGlobalScope(AuthorizationScope::class)
            ->where('iam_user_id', $user->id)
            ->where('login_mechanism', Password::LOGINNAME)
            ->first();

        if(!$mechanism)
            throw OAuthExceptions::mechanismNotFound();

        $isLoggedIn = (new Password())->attempt($mechanism, $password);


    }

    public static function loginWithEmailOTP($code, $password)
    {

    }
}
