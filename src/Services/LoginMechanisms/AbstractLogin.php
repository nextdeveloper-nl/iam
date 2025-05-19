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

use Illuminate\Support\Facades\DB;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Database\Models\Users;

/**
 * Interface ILoginService
 * @package PlusClouds\Account\Common\Services\OAuth2
 */
class AbstractLogin
{
    public $className;

    /**
     * Generates a password and updates the login mechanism objects
     *
     * @param LoginMechanisms $mechanism
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

    /**
     * This function will remove old tokens so that the customer wont be using the old access tokens
     *
     * @param $client
     * @param $identifier
     * @return void
     */
    public function removeOldTokens($clientId, $identifier, $userId) {
        $sql = 'delete from oauth_access_tokens where id != "' . $identifier . '" and client_id = "' . $clientId . '" and user_id = ' . $userId . ' and expires_at < now();';

        DB::delete($sql);
    }

    public function hashPassword($password) {
        $algo = $this->getAvailableHashAlgorithm();

        return password_hash($password, $algo);

        return $hash;
    }

    public function getAvailableHashAlgorithm() {
        $hashes = config('iam.hash_algorithms');

        return $hashes[0];
    }

    /**
     * Returns the latest login mechanism for relates user
     *
     * @param Users $user
     * @param $mechanismName
     * @return LoginMechanisms|null
     */
    public static function getLatestMechanism(Users $user, $mechanismName) : ?LoginMechanisms
    {
        $mechanism = LoginMechanisms::withoutGlobalScopes()
            ->where('iam_user_id', $user->id)
            ->where('login_mechanism', $mechanismName)
            ->where('is_active', 1)
            ->where('is_latest', 1)
            ->whereNull('deleted_at')
            ->first();

        return $mechanism;
    }
}
