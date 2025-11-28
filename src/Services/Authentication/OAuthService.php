<?php

namespace NextDeveloper\IAM\Services\Authentication;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use NextDeveloper\IAM\AuthenticationGrants\OneTimeEmail;
use NextDeveloper\IAM\AuthenticationGrants\Password;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Database\Models\OauthClients;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Exceptions\OAuthExceptions;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\LoginMechanismsService;

class OAuthService
{
    private const TIMEOUT = 3000;

    public static function createSession($clientId, $requestUri, $scope = []) :?string {
        $oauthClient = OauthClients::where('id', $clientId)
            ->where('redirect', $requestUri)
            ->first();

        if(!$oauthClient) {
            return null;
        }

        $session = Str::random(32);

        Cache::put('auth-session:' . $session, [
            'client_id' => $clientId,
            'redirect' => $requestUri,
            'scope' => $scope,
            'requires_2fa' => false,
        ], self::TIMEOUT);

        return $session;
    }

    public static function getValidationStatus($sessionId)
    {
        $sessionData = Cache::get('auth-session:' . $sessionId);

        if(!$sessionData) {
            return null;
        }

        $data = [
            'has_user' => isset($sessionData['iam_user_id']),
            'is_2fa_enabled' => $sessionData['is_2fa_enabled'] ?? false,
            'is_password_validated' => $sessionData['is_password_validated'] ?? false,
            'is_otp_email_validated' => $sessionData['is_otp_email_validated'] ?? false,
            'requires_2fa' => $sessionData['requires_2fa'] ?? false,
            'can_get_auth_code' => (
                (isset($sessionData['is_password_validated']) && $sessionData['is_password_validated'] === true) ||
                (isset($sessionData['is_otp_email_validated']) && $sessionData['is_otp_email_validated'] === true)
            )
        ];

        if(!isset($sessionData['iam_user_id'])) {
            return $data;
        }

        return $data;
    }

    public static function sendOtpEmail($sessionId)
    {
        $sessionData = Cache::get('auth-session:' . $sessionId);

        if(!$sessionId) {
            throw OAuthExceptions::invalidSession();
        }

        if(!isset($sessionData['iam_user_id'])) {
            throw OAuthExceptions::userNotFound();
        }

        $user = UserHelper::getWithEmail($sessionData['email']);

        if(!$user) {
            throw OAuthExceptions::userNotFound();
        }

        (new \NextDeveloper\IAM\AuthenticationGrants\OneTimeEmail())->create($user);

        return true;
    }

    public static function validateOtpEmail($sessionId, $otp)
    {
        $sessionData = Cache::get('auth-session:' . $sessionId);

        if(!$sessionId || !isset($sessionData['iam_user_id'])) {
            throw OAuthExceptions::invalidSession();
        }

        $user = UserHelper::getWithEmail($sessionData['email']);

        $loginMechanisms = LoginMechanismsService::getByUserObject($user);

        $oneTimeEmail = null;

        foreach ($loginMechanisms as $loginMechanism) {
            if($loginMechanism->login_mechanism === OneTimeEmail::LOGINNAME) {
                $oneTimeEmail = $loginMechanism;
                break;
            }
        }

        if(!$oneTimeEmail) {
            throw OAuthExceptions::mechanismNotFound();
        }

        $isLoggedIn = (new OneTimeEmail())->attempt($oneTimeEmail, $otp);

        $sessionData['is_otp_email_validated'] = $isLoggedIn;

        Cache::put('auth-session:' . $sessionId, $sessionData, self::TIMEOUT);

        return $isLoggedIn;
    }

    public static function validatePassword($sessionId, $password)
    {
        $sessionData = Cache::get('auth-session:' . $sessionId);

        if(!$sessionId || !isset($sessionData['iam_user_id'])) {
            throw OAuthExceptions::invalidSession();
        }

        $user = UserHelper::getWithEmail($sessionData['email']);

        $loginMechanisms = LoginMechanismsService::getByUserObject($user);

        $passwordMechanism = null;

        foreach ($loginMechanisms as $mechanism) {
            if($mechanism->login_mechanism === Password::LOGINNAME) {
                $passwordMechanism = $mechanism;
                break;
            }
        }

        if(!$passwordMechanism) {
            throw OAuthExceptions::mechanismNotFound();
        }

        $isLoggedIn = (new Password())->attempt($passwordMechanism, $password);

        $sessionData['is_password_validated'] = $isLoggedIn;

        Cache::put('auth-session:' . $sessionId, $sessionData, self::TIMEOUT);

        return $isLoggedIn;
    }

    public static function getLoginMechanisms($sessionId, $username = null, $email = null){
        $sessionData = Cache::get('auth-session:' . $sessionId);

        $user = null;

        if($email)
            $user = UserHelper::getWithEmail($email);

        if($username)
            $user = UserHelper::getWithUsername($username);

        if(!$user) {
            throw OAuthExceptions::userNotFound();
        }

        $sessionData['iam_user_id'] = $user->id;
        $sessionData['email'] = $user->email;
        $sessionData['username'] = $user->username;

        Cache::put('auth-session:' . $sessionId, $sessionData, self::TIMEOUT);

        $mechanisms = LoginMechanismsService::getByUserObject($user);

        $mechanismList = [];

        foreach ($mechanisms as $mechanism) {
            $mechanismList[] = $mechanism->login_mechanism;
        }

        return $mechanismList;
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

        $sessionData['iam_user_id'] = $user->id;

        $mechanism = LoginMechanisms::withoutGlobalScope(AuthorizationScope::class)
            ->where('iam_user_id', $user->id)
            ->where('login_mechanism', Password::LOGINNAME)
            ->first();

        if(!$mechanism)
            throw OAuthExceptions::mechanismNotFound();

        $isLoggedIn = (new Password())->attempt($mechanism, $password);

        $sessionData['password_login'] = $isLoggedIn;

        Cache::set('auth-session:' . $session, $sessionData, self::TIMEOUT);

        return $isLoggedIn;
    }

    public static function getAuthCode($session)
    {
        $sessionData = Cache::get('auth-session:' . $session);

        if(!$sessionData || !isset($sessionData['iam_user_id'])) {
            throw OAuthExceptions::invalidSession();
        }

        if(
            (isset($sessionData['password']) && $sessionData['password'] === true) ||
            (isset($sessionData['email_otp']) && $sessionData['email_otp'] === true)
        ) {
            throw OAuthExceptions::invalidSession('User is not logged in with any logging mechanism.');
        }

        $validationStatus = self::getValidationStatus($session);

        if($validationStatus['can_get_auth_code']) {
            $authCode = uuid_create();

            $authCodeDb = DB::insert('insert into oauth_auth_codes (id, user_id, client_id, scopes, expires_at) values (?, ?, ?, ?, ?)', [
                $authCode,
                $sessionData['iam_user_id'],
                $sessionData['client_id'],
                json_encode($sessionData['scope']),
                Carbon::now()->addSeconds(180)
            ]);

            Cache::put('auth-code:' . $authCode, $sessionData, self::TIMEOUT);

            return $authCode;
        }

        return null;
    }

    public static function getAccessToken($session, $code)
    {
        $sessionData = Cache::get('auth-session:' . $session);

        if(!$sessionData || !isset($sessionData['iam_user_id'])) {
            throw OAuthExceptions::invalidSession();
        }

        return AccessTokenService::getAccessTokenFromAuthCode($sessionData, $code);
    }
}
