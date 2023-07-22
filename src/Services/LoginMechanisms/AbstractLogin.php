<?php
/**
 * This file is part of the PlusClouds.Account library.
 *
 * (c) Semih Turna <semih.turna@plusclouds.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NextDeveloper\IAM\Services\LoginMechanisms;


use DateInterval;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Server\Grant\AbstractGrant;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use NextDeveloper\IAM\Database\Models\IamLoginMechanism;
use NextDeveloper\IAM\Database\Models\IamUser;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface ILoginService
 * @package PlusClouds\Account\Common\Services\OAuth2
 */
class AbstractLogin extends AbstractGrant
{
    public $className;

    /**
     * Generates a password and updates the login mechanism objects
     *
     * @param IamLoginMechanism $mechanism
     * @return string
     */
    public static function generateStrongPassword() : string {
        return '';
    }

    /**
     * Returns the name of the class
     *
     * @param $obj
     * @return string
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public static function getName($obj) : string
    {
        $name = class_basename($obj);
        
        return $name;
    }

    public function getIdentifier()
    {
        throw new \Exception('This authentication grant type is not implemented!!');
        // TODO: Implement getIdentifier() method.
    }

    public function respondToAccessTokenRequest(ServerRequestInterface $request, ResponseTypeInterface $responseType, DateInterval $accessTokenTTL)
    {
        throw new \Exception('This authentication grant type is not implemented!!');
        // TODO: Implement respondToAccessTokenRequest() method.
    }

    /**
     * This function will remove old tokens so that the customer wont be using the old access tokens
     *
     * @param $client
     * @param $identifier
     * @return void
     */
    public function removeOldTokens($clientId, $identifier, $userId) {
        $sql = 'delete from oauth_access_tokens where id != "' . $identifier . '" and client_id = "' . $clientId . '" and user_id = ' . $userId . ';';

        DB::delete($sql);
    }

    /**
     * Returns the latest login mechanism for relates user
     *
     * @param IamUser $user
     * @param $mechanismName
     * @return IamLoginMechanism|null
     */
    public static function getLatestMechanism(IamUser $user, $mechanismName) : ?IamLoginMechanism
    {
        $mechanism = IamLoginMechanism::where('user_id', $user->id)
            ->where('login_mechanism', $mechanismName)
            ->where('is_active', 1)
            ->where('is_latest', 1)
            ->first();

        return $mechanism;
    }
}