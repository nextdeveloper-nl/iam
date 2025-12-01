<?php

namespace NextDeveloper\IAM\Services\Authentication;

use Carbon\Carbon;
use NextDeveloper\Commons\Helpers\RandomHelper;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Database\OAuthModels\OauthAccessTokens;
use NextDeveloper\IAM\Database\OAuthModels\OauthAuthCodes;
use NextDeveloper\IAM\Database\OAuthModels\OauthClients;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Exceptions\OAuthExceptions;

class AccessTokenService
{
    public static function getAccessTokenFromAuthCode($clientId, $authCode) : array
    {
        $authCode = OauthAuthCodes::where('id', $authCode)->first();

        if(!$authCode)
            throw OAuthExceptions::authCodeNotValid();

        $client = OauthClients::where('id', $clientId)->first();

        $user = Users::withoutGlobalScope(AuthorizationScope::class)
            ->where('id', $authCode['user_id'])
            ->first();

        if(!$user)
            throw OAuthExceptions::userNotFound();

        $validUntilSeconds = config('iam.oauth.token_valid_until');

        $accessToken = self::getUniqueAccessToken();
        $expires = Carbon::now()->addSeconds($validUntilSeconds)->toDateTimeString();

        $fingerprint = $authCode['fingerprint'];
        $fingerprint = is_string($fingerprint) ? json_decode($fingerprint, true) : $fingerprint;

        $token = OauthAccessTokens::create([
            'id'        =>  $accessToken,
            'user_id'   =>  $user->id,
            'client_id' =>  $client->id,
            'scopes'    =>  $authCode['scope'],
            'revoked'   =>  0,

            'user_agent'            =>  array_key_exists('user_agent', $fingerprint) ? $fingerprint['user_agent'] : null,
            'ip_address'            =>  array_key_exists('ip_address', $fingerprint) ? $fingerprint['ip_address'] : null,
            'device_fingerprint'    =>  array_key_exists('fingerprint', $fingerprint) ? $fingerprint['fingerprint'] : null,
            'platform'              =>  array_key_exists('platform', $fingerprint) ? $fingerprint['platform'] : null,
            'language'              =>  array_key_exists('language', $fingerprint) ? $fingerprint['language'] : null,
            'timezone_offset'       =>  array_key_exists('timezone_offset', $fingerprint) ? $fingerprint['timezone_offset'] : null,
            'screen_color_depth'    =>  array_key_exists('screen_color_depth', $fingerprint) ? $fingerprint['screen_color_depth'] : null,

            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
            'expires_at'    =>  $expires
        ]);

        //  Deleting previous tokens
        $deleteKeys = OauthAccessTokens::where('user_id', $user->id)
            ->where('id', '!=', $token->id)
            ->where('client_id', $client->id)
            ->whereDate('expires_at', '>=', Carbon::now()->toDateTimeString());

        if(array_key_exists('fingerprint', $fingerprint))
            $deleteKeys = $deleteKeys->where('device_fingerprint', $fingerprint['fingerprint']);

        $deleteKeys->forceDelete();

        $response = [
            'access_token'  =>  $token->id,
            'token_type'    =>  'Bearer',
            'expires_in'    =>  $expires,
            'refresh_token' =>  'not-implemented-yet',
            'scope' =>  ''
        ];

        return $response;
    }

    public static function getUniqueAccessToken() : string
    {
        //  Here we are trying to find a unique ID for access token
        $foundUniqueId = false;

        $uniqueId = '';

        while(!$foundUniqueId) {
            $uniqueId = RandomHelper::uuid();

            $recordExists = OauthAccessTokens::where('id', $uniqueId)->first();

            if(!$recordExists)
                $foundUniqueId = true;
        }

        return $uniqueId;
    }
}
