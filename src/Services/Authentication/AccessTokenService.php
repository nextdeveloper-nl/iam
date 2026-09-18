<?php

namespace NextDeveloper\IAM\Services\Authentication;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use NextDeveloper\Commons\Helpers\RandomHelper;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Database\OAuthModels\OauthAccessTokens;
use NextDeveloper\IAM\Database\OAuthModels\OauthAuthCodes;
use NextDeveloper\IAM\Database\OAuthModels\OauthClients;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Exceptions\OAuthExceptions;
use NextDeveloper\IAM\Helpers\UserHelper;

class AccessTokenService
{
    /**
     * Exchanges an authorization code for an access token.
     *
     * The token belongs to the client the code was issued for (the client of the session the
     * user signed in through). The caller identifies itself with either that session id or that
     * client id - the panel sends the client id, session based clients send the session - and a
     * caller that names a different client gets nothing. A code is spent by the exchange and is
     * only accepted inside its expiry window.
     *
     * @return array{access_token: string, token_type: string, expires_in: int, expires_at: string, refresh_token: string, scope: string}
     * @throws OAuthExceptions
     */
    public static function getAccessTokenFromAuthCode($sessionOrClientId, $authCode) : array
    {
        if(!is_string($authCode) || !Str::isUuid($authCode))
            throw OAuthExceptions::authCodeNotValid();

        $authCode = OauthAuthCodes::where('id', $authCode)
            ->where('revoked', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if(!$authCode)
            throw OAuthExceptions::authCodeNotValid();

        if(!self::isIssuedTo($authCode->client_id, $sessionOrClientId))
            throw OAuthExceptions::clientNotAvailable();

        $client = OauthClients::where('id', $authCode->client_id)
            ->where('revoked', false)
            ->first();

        if(!$client)
            throw OAuthExceptions::clientNotAvailable();

        $user = Users::withoutGlobalScope(AuthorizationScope::class)
            ->where('id', $authCode['user_id'])
            ->first();

        if(!$user)
            throw OAuthExceptions::userNotFound();

        //  Spending the code before the token exists, and only if nobody else spent it first, so two
        //  concurrent exchanges of the same code cannot both succeed.
        $isSpent = OauthAuthCodes::where('id', $authCode->id)
            ->where('revoked', false)
            ->update(['revoked' => true]);

        if(!$isSpent)
            throw OAuthExceptions::authCodeNotValid();

        $validUntilSeconds = (int) config('iam.oauth.token_valid_until');

        $accessToken = self::getUniqueAccessToken();
        $expiresAt = Carbon::now()->addSeconds($validUntilSeconds);
        $expires = $expiresAt->toDateTimeString();

        $fingerprint = $authCode['fingerprint'];
        $fingerprint = (is_string($fingerprint) ? json_decode($fingerprint, true) : $fingerprint) ?: [];

        $token = OauthAccessTokens::create([
            'id'        =>  $accessToken,
            'user_id'   =>  $user->id,
            'client_id' =>  $client->id,
            'scopes'    =>  $authCode['scopes'],
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
            'expires_in'    =>  $validUntilSeconds,
            'expires_at'    =>  $expiresAt->toIso8601String(),
            'refresh_token' =>  'not-implemented-yet',
            'scope' =>  ''
        ];

        return $response;
    }

    /**
     * Revokes an access token. Holding the token is the authority to revoke it, and an unknown
     * token is not an error: either way the token no longer works (RFC 7009, section 2.2).
     *
     * The row is deleted rather than flagged, because the request authentication looks tokens up
     * by id and does not read `revoked`.
     */
    public static function revokeAccessToken(?string $token) : bool
    {
        if(!$token || !Str::isUuid($token))
            return false;

        return OauthAccessTokens::where('id', $token)->delete() > 0;
    }

    /**
     * Whether the caller of a code exchange names the client the code was issued to, either by
     * its id or by the sign-in session created for it.
     */
    private static function isIssuedTo(string $clientId, $sessionOrClientId) : bool
    {
        if(!is_string($sessionOrClientId) || $sessionOrClientId === '')
            return false;

        if(Str::lower($sessionOrClientId) === Str::lower($clientId))
            return true;

        $session = Cache::get('auth-session:' . $sessionOrClientId);

        if(!is_array($session))
            return false;

        $sessionClientId = $session['client_id'] ?? config('iam.oauth.default_client_id');

        return is_string($sessionClientId) && Str::lower($sessionClientId) === Str::lower($clientId);
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

    public static function generateToken($name, $expires_at, $appName = 'My personal application')
    {
        $client = DB::table('oauth_clients')->where('user_id', UserHelper::me()->id)->first();

        if (!$client) {
            $client = self::createApplication($appName);
        } else {
            $client = $client->id;
        }

        $token = DB::table('oauth_access_tokens')->insertGetId([
            'user_id' => UserHelper::me()->id,
            'client_id' => $client,
            'name' => $name,
            'scopes' => '[]',
            'account_id'    =>  UserHelper::currentAccount()->id,
            'created_at' => now(),
            'updated_at' => now(),
            'expires_at' => $expires_at
        ]);

        return [
            'name' => $name,
            'token' => $token,
            'expires_at' => $expires_at
        ];
    }

    public static function createApplication($name)
    {
        return DB::table('oauth_clients')->insertGetId([
            'user_id' => UserHelper::me()->id,
            'account_id' => UserHelper::currentAccount()->id,
            'name' => $name,
            'secret' => Str::random(40),
            'personal_access_client' => 1,
            'redirect' => 'http://127.0.0.1:8000/callback',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
