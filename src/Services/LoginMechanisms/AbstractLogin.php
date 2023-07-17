<?php
/**
 * This file is part of the PlusClouds.Account library.
 *
 * (c) Semih Turna <semih.turna@plusclouds.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NextDeveloper\Authentication\Services\LoginMechanisms;


use DateInterval;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Server\Grant\AbstractGrant;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use NextDeveloper\Authentication\Database\Models\AuthenticationLoginMechanism;
use Psr\Http\Message\ServerRequestInterface;
use function Symfony\Component\String\s;

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
     * @param AuthenticationLoginMechanism $mechanism
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
    public function removeOldTokens($clientId, $identifier) {
        $sql = 'delete from oauth_access_tokens where id != "' . $identifier . '" and client_id = "' . $clientId . '";';

        DB::delete($sql);
    }
}