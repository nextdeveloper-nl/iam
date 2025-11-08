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
            clientSecret: $request->validated('client_secret'),
            requestUri: $request->validated('redirect_uri'),
        );

        if($session === null)
            return ResponseHelper::error('Cannot find oauth app, that is why we cannot create the session');

        return ResponseHelper::data($session);
    }

    public static function usernamePasswordLogin(OauthUsernamePasswordLoginRequest $request) {
        $token = OAuthService::loginWithUsernamePassword(
            code: $request->validated('code'),
            username: $request->validated('username'),
            password: $request->validated('password')
        );

        if($token instanceof \Exception)
            throw $token;

        return ResponseHelper::data($token);
    }

    public static function otpEmailLogin() {
        $token = OAuthService::loginWithEmailOTP();
    }
}
