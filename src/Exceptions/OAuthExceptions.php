<?php

namespace NextDeveloper\IAM\Exceptions;

use NextDeveloper\I18n\Helpers\i18n;
use Throwable;

class OAuthExceptions extends \Exception
{
    public static function invalidSession($hint = null, Throwable $previous = null)
    {
        $errorMessage = I18n::t('We dont have any session matching the provided session id. Please make sure that '
            . 'you are providing correct session id.');

        $hint = ($hint === null) ? null : $hint;

        return new static($errorMessage, 3, $previous);
    }

    public static function clientNotAvailable($hint = null, Throwable $previous = null) {
        $errorMessage = I18n::t('The requested client does not exists. Please make sure that you are providing ' .
            'correct client_id and client_secret.');

        $hint = ($hint === null) ? null : $hint;

        return new static($errorMessage, 3, $previous);
    }

    public static function authCodeNotValid($hint = null, Throwable $previous = null) {
        $errorMessage = I18n::t('The authorization code is not valid. It may have been expired, since we have ' .
            'very small time window for validating and taking the authorization code. Also you may have been ' .
            'providing really wrong authorization code.');

        $hint = ($hint === null) ? null : $hint;

        return new static($errorMessage, 3, $previous);
    }

    public static function userNotFound($hint = null, Throwable $previous = null) {
        $errorMessage = I18n::t('Cannot find the user you are asking for. Please make sure that you are providing ' .
            'correct username. If you are using email login, and you believe that your account is registered, then ' .
            'please try to resend a new password');

        $hint = ($hint === null) ? null : $hint;

        return new static($errorMessage, 3, $previous);
    }

    public static function passwordNotValid($hint = null, Throwable $previous = null) {
        $errorMessage = I18n::t('The password you are providing is not valid. Please make sure that you are ' .
            'providing correct password.');

        $hint = ($hint === null) ? null : $hint;

        return new static($errorMessage, 3, $previous);
    }

    public static function mechanismNotFound($hint = null, Throwable $previous = null) {
        $errorMessage = I18n::t('The mechanism you are asking for is not found. Please make sure that you are ' .
            'providing correct mechanism.');

        $hint = ($hint === null) ? null : $hint;

        return new static($errorMessage, 3, $previous);
    }

    public static function grantTypeNotValid($hint = null, Throwable $previous = null) {
        $errorMessage = I18n::t('The grant type you are asking for is not found. Please make sure that you are ' .
            'providing correct grant type. Grant types can be; otp_email, otp_sms, password.');

        $hint = ($hint === null) ? null : $hint;

        return new static($errorMessage, 3, $previous);
    }
}
