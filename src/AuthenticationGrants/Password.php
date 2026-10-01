<?php

namespace NextDeveloper\IAM\AuthenticationGrants;

use NextDeveloper\Events\Services\Events;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Services\LoginMechanisms\AbstractLogin;
use NextDeveloper\IAM\Services\LoginMechanisms\ILoginService;
use Random\RandomException;

/**
 * Class Password
 *
 * @package App\Grants
 */
class Password extends AbstractLogin implements ILoginService
{
    /**
     * The login mechanism name.
     */
    const LOGINNAME = 'Password';

    /**
     * Creates a new login mechanism for the given user.
     *
     * @param Users $user The user for whom the login mechanism is being created.
     *
     * @return LoginMechanisms The created login mechanism.
     */
    public function create(Users $user): LoginMechanisms
    {
        $mechanism = self::findMechanism($user);

        if (!$mechanism) {
            $mechanism = self::newLoginMechanism($user);
        }

        Events::fire('created:NextDeveloper\IAM\LoginMechanisms', $mechanism);

        return $mechanism;
    }

    /**
     * Updates the password for the given user.
     *
     * @param Users $user     The user whose password is being updated.
     * @param mixed $password The new password.
     *
     * @return bool True if the password is updated successfully, false otherwise.
     */
    public function update(Users $user, mixed $password): bool
    {
        $mechanism = self::findMechanism($user);

        if (!$mechanism) {
            $mechanism = self::newLoginMechanism($user);
        }

        //  Only the hash is kept; the plain password is never stored.
        $mechanism->update([
            'login_data'    => [
                'passwordHash'          => $this->hashPassword((string) $password),
                'password_updated_at'   => now()->toDateTimeString(),
            ],
            'is_latest'     => true,
            'is_default'    => true,
            'is_active'     => true,
        ]);

        Events::fire('updated:NextDeveloper\IAM\LoginMechanisms', $mechanism);

        return true;
    }

    /**
     * Returns the password mechanism of the user, whether or not it is flagged as the latest one.
     * A user has a single password mechanism, so it is updated in place instead of duplicated.
     *
     * @param Users $user
     * @return LoginMechanisms|null
     */
    public static function findMechanism(Users $user): ?LoginMechanisms
    {
        return LoginMechanisms::withoutGlobalScopes()
            ->where('iam_user_id', $user->id)
            ->where('login_mechanism', self::LOGINNAME)
            ->whereNull('deleted_at')
            ->orderByDesc('is_latest')
            ->orderByDesc('id')
            ->first();
    }

    /**
     * Whether the user has a usable password.
     *
     * @param Users $user
     * @return bool
     */
    public static function hasPassword(Users $user): bool
    {
        $mechanism = self::findMechanism($user);

        return $mechanism && $mechanism->is_active && !empty($mechanism->login_data['passwordHash']);
    }

    /**
     * Retrieves the latest login mechanism for the given user.
     *
     * @param Users  $user          The user for whom to retrieve the login mechanism.
     * @param string $mechanismName The name of the login mechanism to retrieve.
     *
     * @return LoginMechanisms|null The latest login mechanism, or null if none is found.
     */
    public static function getLatestMechanism(Users $user, $mechanismName = self::LOGINNAME): LoginMechanisms|null
    {
        return parent::getLatestMechanism($user, $mechanismName);
    }

    /**
     * Attempts to log in using the provided credentials.
     *
     * @param LoginMechanisms $mechanism The login mechanism to use for authentication.
     * @param mixed           $password  The password to verify.
     *
     * @return bool True if the authentication is successful, false otherwise.
     */
    public function attempt(LoginMechanisms $mechanism, $password): bool
    {
        $loginData = $mechanism->login_data;

        if (is_array($password)) {
            $password = $password['password'];
        }

        if (!is_string($password) || $password === '' || empty($loginData['passwordHash'])) {
            return false;
        }

        if (!password_verify($password, $loginData['passwordHash'])) {
            return false;
        }

        //  Upgrade the hash when the configured algorithm changed.
        if (password_needs_rehash($loginData['passwordHash'], $this->getAvailableHashAlgorithm())) {
            $loginData['passwordHash'] = $this->hashPassword($password);
            $mechanism->update(['login_data' => $loginData]);
        }

        return true;
    }

    /**
     * Returns the identifier of the grant.
     *
     * @return string The grant type.
     */
    public function getIdentifier(): string
    {
        return 'password';
    }

    /**
     * Generates a random password and updates the login mechanism with the hashed password.
     *
     * @param LoginMechanisms $mechanism The login mechanism to update.
     *
     * @return string The generated password.
     * @throws RandomException If a random password cannot be generated.
     */
    public function generatePassword(LoginMechanisms $mechanism): string
    {
        $password = self::generateStrongPassword();

        $mechanism->update([
            'login_data' => [
                'passwordHash'          => $this->hashPassword($password),
                'password_updated_at'   => now()->toDateTimeString(),
            ]
        ]);

        return $password;
    }

    /**
     * Creates a new login mechanism for the given user.
     *
     * @param Users $user The user for whom the login mechanism is being created.
     *
     * @return LoginMechanisms The created login mechanism.
     */
    protected static function newLoginMechanism(Users $user): LoginMechanisms
    {
        $mechanism = LoginMechanisms::create([
            'iam_user_id' => $user->id,
            'login_mechanism' => self::LOGINNAME,
            'login_data' => [],
            'is_latest' => true,
            'is_default' => true,
            'is_active' => true,
        ]);
        return $mechanism;
    }
}
