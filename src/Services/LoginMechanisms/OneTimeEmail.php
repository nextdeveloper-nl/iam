<?php

namespace NextDeveloper\Authentication\Services\LoginMechanisms;

use DateInterval;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use NextDeveloper\Accounts\Database\Models\User;
use NextDeveloper\Accounts\Services\UserService;
use NextDeveloper\Authentication\Database\Models\AuthenticationLoginMechanism;
use Psr\Http\Message\ServerRequestInterface;

class OneTimeEmail extends AbstractLogin implements ILoginService
{
    const LOGINNAME = 'OneTimeEmail';

    /**
     * Here we will create one time email type of login mechanism. To do that we need to first check if we have
     * the mechanism already. To do that we will check the mechanism with user_id. If the mechanism is already
     * created we will return the mechanism, if not we will create and return the mechanism.
     *
     * @param User $user
     * @return AuthenticationLoginMechanism
     */
    public function create(User $user) : AuthenticationLoginMechanism
    {
        $latestMechanism = self::getLatestMechanism($user);

        if (!$latestMechanism) {
            return AuthenticationLoginMechanism::create([
                'user_id'          => $user->id,
                'login_mechanism'  => self::LOGINNAME,
            ]);
        }

        return $latestMechanism;

    }

    /**
     *
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

        //  We take the password
        $otp = $this->getRequestParameter('password', $request);

        $user = UserService::getByEmail($username);

        if(!$user) {
            //  Registering the user
            $user = UserService::createWithEmail($username);
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

        $this->removeOldTokens($client->getIdentifier(), $accessToken->getIdentifier());

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
     * @param AuthenticationLoginMechanism $mechanism
     * @return string
     */
    public function generatePassword(AuthenticationLoginMechanism $mechanism) : string
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
     * @param AuthenticationLoginMechanism $mechanism
     * @param $loginData
     * @return true
     */
    public function attempt(AuthenticationLoginMechanism $mechanism, $loginData) : bool
    {
        return true;
        // TODO: Implement attempt() method.
    }

    private static function getLatestMechanism(User $user) : ?AuthenticationLoginMechanism
    {
        $mechanism = AuthenticationLoginMechanism::where('user_id', $user->id)
            ->where('login_mechanism', 'OneTimeEmail')
            ->where('is_active', 1)
            ->where('is_latest', 1)
            ->first();

        return $mechanism;
    }
}