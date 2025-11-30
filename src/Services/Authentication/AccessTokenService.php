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

        $token = OauthAccessTokens::create([
            'id'        =>  $accessToken,
            'user_id'   =>  $user->id,
            'client_id' =>  $client->id,
            'scopes'    =>  $authCode['scope'],
            'revoked'   =>  0,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
            'expires_at'    =>  $expires
        ]);

        //  Deleting previous tokens
        OauthAccessTokens::where('user_id', $user->id)
            ->where('id', '!=', $token->id)
            ->where('client_id', $client->id)
            ->whereDate('expires_at', '>=', Carbon::now()->toDateTimeString())
            ->forceDelete();

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
