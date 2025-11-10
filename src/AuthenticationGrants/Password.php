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
        $latestMechanism = self::getLatestMechanism($user);

        if (!$latestMechanism) {
            $latestMechanism = self::newLoginMechanism($user);

            $password = $this->generatePassword($latestMechanism);
            // TODO: Send the password to the user's email
        }

        Events::fire('created:NextDeveloper\IAM\LoginMechanisms', $latestMechanism);

        return $latestMechanism;
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
        $latestMechanism = self::getLatestMechanism($user);

        if (!$latestMechanism) {
            $latestMechanism = self::newLoginMechanism($user);
        }

        $latestMechanism->update([
            'login_data' => [
                'passwordHash'  => self::hashPassword($password),
                'password'      => $password,
            ]
        ]);

        Events::fire('updated:NextDeveloper\IAM\LoginMechanisms', $latestMechanism);

        return true;
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

        $isVerified = password_verify($password, $loginData['passwordHash']);

        if (!$isVerified) {
            return false;
        }

        $mechanism->is_latest = false;
        $mechanism->save();

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
        // Generate a random 6-digit password and hash it using Argon2
        // Suggestions: We can use generateStrongPassword() from the AbstractLogin class
        $password = random_int(100000, 999999);
        $hashedPassword = $this->hashPassword($password);

        $mechanism->update([
            'login_data' => [
                'passwordHash' => $hashedPassword,
                'tempPassword' => $password
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
        ]);
        return $mechanism;
    }
}
