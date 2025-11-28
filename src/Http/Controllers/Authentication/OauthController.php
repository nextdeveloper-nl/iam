<?php

namespace NextDeveloper\IAM\Http\Controllers\Authentication;

use App\Helpers\Http\ResponseHelper;
use NextDeveloper\IAM\Exceptions\OAuthExceptions;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\IAM\Http\Requests\Authentication\OAuthGetLoginMechanismsRequest;
use NextDeveloper\IAM\Http\Requests\Authentication\OauthOtpEmailValidationRequest;
use NextDeveloper\IAM\Http\Requests\Authentication\OauthPasswordValidationRequest;
use NextDeveloper\IAM\Http\Requests\Authentication\OauthUsernamePasswordLoginRequest;
use NextDeveloper\IAM\Http\Requests\Authentication\OauthSessionCreateRequest;
use NextDeveloper\IAM\Services\Authentication\OAuthService;
use NextDeveloper\IAM\Services\LoginMechanismsService;

class OauthController extends AbstractController
{
    public function createSession(OauthSessionCreateRequest $request)
    {
        try {
            $session = OAuthService::createSession(
                clientId: $request->validated('client_id'),
                requestUri: $request->validated('redirect_uri'),
            );

            if($session === null)
                return ResponseHelper::error('Cannot find oauth app, that is why we cannot create the session');

            return ResponseHelper::data($session);
        } catch (OAuthExceptions $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }

    public function getLoginMechanisms($sessionId, OAuthGetLoginMechanismsRequest $request)
    {
        try {
            return OAuthService::getLoginMechanisms(
                sessionId: $sessionId,
                username: $request->validated('username'),
                email: $request->validated('email')
            );
        } catch (OAuthExceptions $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }

    public function usernamePasswordLogin($session, OauthUsernamePasswordLoginRequest $request) {
        try {
            $session = OAuthService::loginWithUsernamePassword(
                session: $session,
                username: $request->validated('username'),
                password: $request->validated('password')
            );

            if($session instanceof \Exception)
                throw $session;

            //  Returning the session token
            return ResponseHelper::data($session);
        } catch (OauthExceptions $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }

    public function getValidationStatus($sessionId)
    {
        try {
            return ResponseHelper::data(
                OAuthService::getValidationStatus($sessionId)
            );
        } catch (OAuthExceptions $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }

    public function getAuthCode($session)
    {
        return OAuthService::getAuthCode($session);
    }

    public function getToken($session)
    {
        $authCode = request()->get('code');

        return OAuthService::getAccessToken($session, $authCode);
    }

    public function validatePassword($sessionId, OauthPasswordValidationRequest $request) {
        try {
            OAuthService::validatePassword(
                sessionId: $sessionId,
                password: $request->validated('password')
            );
        } catch (OauthExceptions $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }

    public function sendOtpEmail($sessionId)
    {
        try {
            return ResponseHelper::data(OAuthService::sendOtpEmail(
                sessionId: $sessionId
            ));
        } catch (OAuthExceptions $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }

    public function validateOtpEmail($sessionId, OauthOtpEmailValidationRequest $request) {
        try {
            return ResponseHelper::data(OAuthService::validateOtpEmail(
                sessionId: $sessionId,
                otp: $request->validated('password')
            ));
        } catch (OauthExceptions $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }
}
