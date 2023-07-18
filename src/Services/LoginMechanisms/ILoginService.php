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

use NextDeveloper\IAM\Database\Models\IamUser;
use NextDeveloper\IAM\Database\Models\IamLoginMechanism;

/**
 * Interface ILoginService
 * @package PlusClouds\Account\Common\Services\OAuth2
 */
interface ILoginService
{
    const LOGINNAME = 'DEFAULT';

    /**
     * Here we check if the user credentials are correct. Even if the credentials are correct or not we will log
     * this attempt.
     *
     * @param IamLoginMechanism $mechanism
     * @param array $loginData
     * @return true
     */
    public function attempt(IamLoginMechanism $mechanism, array $loginData) : bool;

    /**
     * Generates a password and updates the login mechanism objects
     *
     * @param IamLoginMechanism $mechanism
     * @return string
     */
    public function generatePassword(IamLoginMechanism $mechanism) : string;

    /**
     * Here we will create one time email type of login mechanism. To do that we need to first check if we have
     * the mechanism already. To do that we will check the mechanism with user_id. If the mechanism is already
     * created we will return the mechanism, if not we will create and return the mechanism.
     *
     * @param User $user
     * @return IamLoginMechanism
     */
    public function create(IamUser $user) : IamLoginMechanism;
}