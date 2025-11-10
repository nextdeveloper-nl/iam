<?php

namespace NextDeveloper\IAM\AuthenticationGrants;

use App\Exceptions\OAuthExceptions;
use Carbon\Carbon;
use DateInterval;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use NextDeveloper\IAM\Authorization\Roles\MemberRole;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Services\LoginMechanisms\AbstractLogin;
use NextDeveloper\IAM\Services\LoginMechanisms\ILoginService;
use NextDeveloper\IAM\Services\UsersService;
use Psr\Http\Message\ServerRequestInterface;

class Code extends AbstractLogin implements ILoginService
{
    const LOGINNAME = 'Code';

    public function create(Users $user) : LoginMechanisms
    {
        //  We will create a password login mechanism
    }

    public static function update(Users $user, $password) : LoginMechanisms
    {
        //  Here we will update the password hash of latest password mechanism
        //  We will be using Argos2 hash mechanism for this.
    }

    public static function getLatestMechanism(Users $user, $mechanismName) : LoginMechanisms
    {
        //  Here we return the latest Password mechanism
    }

    public function attempt(LoginMechanisms $mechanism, array $loginData): bool
    {
        dd('asd');
        // TODO: Implement attempt() method.
    }

    /**
     * Creates and responds with authentication token
     *
     * @param ServerRequestInterface $request
     * @param ResponseTypeInterface $responseType
     * @param DateInterval $accessTokenTTL
     * @return ResponseTypeInterface
     * @throws OAuthServerException
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function respondToAccessTokenRequest(ServerRequestInterface $request, ResponseTypeInterface $responseType, DateInterval $accessTokenTTL)
    {
        //  Here we take the client
        $client = $this->validateClient($request);

        //  Here we take the scopes
        $scopes = $this->validateScopes($this->getRequestParameter('scope', $request));

        //  Here we take the username
        $username = $this->getRequestParameter('username', $request);

        //  We take the code
        $code = $this->getRequestParameter('code', $request);

        $user = UsersService::getByEmail($username);

        //  Attempting here because this grant type does not have password to check. Only code.
        $authCode = DB::table('oauth_auth_codes')
            ->select('*')
            ->where('id', $code)
            ->where('user_id', $user->id)
            ->where('client_id', $client->getIdentifier())
            ->where('expires_at', '>=', Carbon::now()->toDateTimeString())
            ->first();

        if(!$authCode) {
            throw OAuthExceptions::invalidSession('The session of the code is expired. Please login again'
                . ' but this time be faster to complete all process in 2 mins.');
        }

        // Issue and persist new tokens
        $accessToken = $this->issueAccessToken($accessTokenTTL, $client, $user->id, $scopes);

        // Inject tokens into response
        $responseType->setAccessToken($accessToken);
        //$responseType->setRefreshToken($refreshToken);

        $this->removeOldTokens($client->getIdentifier(), $accessToken->getIdentifier(), $user->id);

        // We need to make role checking here. If the role is not assigned to user, we need to assign member role
        UsersService::assignUserToRole($user, new MemberRole());

        return $responseType;
    }

    /**
     * Returns the identifier of the grant
     *
     * @return string grant type
     */
    public function getIdentifier()
    {
        return 'code';
    }

    public function generatePassword(LoginMechanisms $mechanism): string
    {
        // TODO: Implement generatePassword() method.
    }
}
