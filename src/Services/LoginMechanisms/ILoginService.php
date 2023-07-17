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


use NextDeveloper\Accounts\Database\Models\User;
use NextDeveloper\Authentication\Database\Models\AuthenticationLoginMechanism;

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
     * @param AuthenticationLoginMechanism $mechanism
     * @param array $loginData
     * @return true
     */
    public function attempt(AuthenticationLoginMechanism $mechanism, array $loginData) : bool;

    /**
     * Generates a password and updates the login mechanism objects
     *
     * @param AuthenticationLoginMechanism $mechanism
     * @return string
     */
    public function generatePassword(AuthenticationLoginMechanism $mechanism) : string;

    /**
     * Here we will create one time email type of login mechanism. To do that we need to first check if we have
     * the mechanism already. To do that we will check the mechanism with user_id. If the mechanism is already
     * created we will return the mechanism, if not we will create and return the mechanism.
     *
     * @param User $user
     * @return AuthenticationLoginMechanism
     */
    public function create(User $user) : AuthenticationLoginMechanism;
}