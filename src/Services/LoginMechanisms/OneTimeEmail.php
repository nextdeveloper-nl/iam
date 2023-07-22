<?php

namespace NextDeveloper\IAM\Services\LoginMechanisms;

use DateInterval;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use NextDeveloper\IAM\Authorization\Roles\MemberRole;
use NextDeveloper\IAM\Database\Models\IamLoginMechanism;
use NextDeveloper\IAM\Database\Models\IamUser;
use NextDeveloper\IAM\Services\IamRoleService;
use NextDeveloper\IAM\Services\IamUserService;
use Psr\Http\Message\ServerRequestInterface;

class OneTimeEmail extends AbstractLogin implements ILoginService
{
    const LOGINNAME = 'OneTimeEmail';

    /**
     * Here we will create one time email type of login mechanism. To do that we need to first check if we have
     * the mechanism already. To do that we will check the mechanism with user_id. If the mechanism is already
     * created we will return the mechanism, if not we will create and return the mechanism.
     *
     * @param IamUser $user
     * @return IamLoginMechanism
     */
    public function create(IamUser $user) : IamLoginMechanism
    {
        $latestMechanism = self::getLatestMechanism($user);

        if (!$latestMechanism) {
            return IamLoginMechanism::create([
                'user_id'          => $user->id,
                'login_mechanism'  => self::LOGINNAME,
            ]);
        }

        return $latestMechanism;
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

        //  We take the OTP
        $otp = $this->getRequestParameter('password', $request);

        $user = IamUserService::getByEmail($username);

        if(!$user) {
            //  Registering the user
            $user = IamUserService::createWithEmail($username);
        }

        $mechanism = self::getLatestMechanism($user);

        //  If we dont have the mechanism, we are creating one.
        if(!$mechanism) {
            $mechanism = self::create($user);
        }

        //  Checking if the user is valid
        $isValid = self::attempt($mechanism, [
            'password'  =>  $otp
        ]);

        // Issue and persist new tokens
        $accessToken = $this->issueAccessToken($accessTokenTTL, $client, $user->id, $scopes);

        // Inject tokens into response
        $responseType->setAccessToken($accessToken);
        //$responseType->setRefreshToken($refreshToken);

        $this->removeOldTokens($client->getIdentifier(), $accessToken->getIdentifier(), $user->id);

        // We need to make role checking here. If the role is not assigned to user, we need to assign member role
        IamUserService::assignUserToRole($user, new MemberRole());

        return $responseType;
    }

    /**
     * Returns the identifier of the grant
     *
     * @return string grant type
     */
    public function getIdentifier()
    {
        return 'otp_email';
    }

    /**
     * Generates a password and updates the login mechanism objects
     *
     * @param IamLoginMechanism $mechanism
     * @return string
     */
    public function generatePassword(IamLoginMechanism $mechanism) : string
    {
        /**
         * For this service we will be sending an email to the user so that the user knows his/her password for the
         * login.
         */

        $password = random_int(100000, 999999);

        $updateMechanismLoginData = $mechanism->update([
            'login_data' => json_encode(["password" => bcrypt($password)])
        ]);

        // TODO: Send email to the user with the password

        return $password;
    }

    /**
     * Here we check if the user credentials are correct. Even if the credentials are correct or not we will log
     * this attempt.
     *
     * @param IamLoginMechanism $mechanism
     * @param $loginData
     * @return true
     */
    public function attempt(IamLoginMechanism $mechanism, $loginData) : bool
    {
        $user = $mechanism->iamUser();

        //$role = IamRoleService::

        return true;
        // TODO: Implement attempt() method.
    }

    /**
     * Returns the mechanism name
     *
     * @param IamUser $user
     * @param $mechanismName
     * @return IamLoginMechanism|null
     */
    public static function getLatestMechanism(IamUser $user, $mechanismName = self::LOGINNAME) : ?IamLoginMechanism
    {
        $mechanism = parent::getLatestMechanism($user, $mechanismName);

        return $mechanism;
    }
}