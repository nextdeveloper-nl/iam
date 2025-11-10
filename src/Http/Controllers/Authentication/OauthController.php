<?php

namespace NextDeveloper\IAM\Http\Controllers\Authentication;

use App\Helpers\Http\ResponseHelper;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\IAM\Http\Requests\Authentication\OauthOtpEmailRequest;
use NextDeveloper\IAM\Http\Requests\Authentication\OauthUsernamePasswordLoginRequest;
use NextDeveloper\IAM\Http\Requests\Authentication\OauthSessionCreateRequest;
use NextDeveloper\IAM\Services\Authentication\OAuthService;

class OauthController extends AbstractController
{
    public static function createSession(OauthSessionCreateRequest $request)
    {
        $session = OAuthService::createSession(
            clientId: $request->validated('client_id'),
            requestUri: $request->validated('redirect_uri'),
        );

        if($session === null)
            return ResponseHelper::error('Cannot find oauth app, that is why we cannot create the session');

        return ResponseHelper::data($session);
    }

    public static function getSessionRequirements() {

    }

    public static function usernamePasswordLogin(OauthUsernamePasswordLoginRequest $request) {
        $session = OAuthService::loginWithUsernamePassword(
            session: $request->validated('session'),
            username: $request->validated('username'),
            password: $request->validated('password')
        );

        if($session instanceof \Exception)
            throw $session;

        //  Returning the session token
        return ResponseHelper::data($session);
    }

    public static function getAuthCode($session)
    {
        return OAuthService::getAuthCode($session);
    }

    public static function sendEmailOtp(OauthOtpEmailRequest $request)
    {

    }

    public static function otpEmailLogin() {
        $token = OAuthService::loginWithEmailOTP();
    }
}
