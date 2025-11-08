<?php

namespace NextDeveloper\IAM\Services;

use App\Grants\OneTimeEmail;
use Illuminate\Database\Eloquent\Collection;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Exceptions\UnauthorizedException;
use NextDeveloper\IAM\Services\AbstractServices\AbstractLoginMechanismsService;

/**
 * This class is responsible from managing the data for LoginMechanisms
 *
 * Class LoginMechanismsService.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class LoginMechanismsService extends AbstractLoginMechanismsService
{

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE


    private $_user;

    public function __construct(Users $user)
    {
        $this->_user = $user;
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
    public function getByUser(): Collection
    {
        $mechanisms = LoginMechanisms::withoutGlobalScopes()
            ->where('iam_user_id', $this->_user->id)
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->get();

        if (!count($mechanisms))
            (new OneTimeEmail())->create($this->_user);

        $mechanisms = LoginMechanisms::withoutGlobalScopes()
            ->where('iam_user_id', $this->_user->id)
            ->where('is_active', 1)
            ->where('login_mechanism', 'not like', '2FA%')
            ->whereNull('deleted_at')
            ->get();

        return $mechanisms;
    }

    public function getMechanismByName($mechanism): ?LoginMechanisms
    {
        foreach ($this->getByUser() as $lm) {
            if ($lm->login_mechanism == $mechanism)
                return $lm;
        }

        return null;
    }

    public function getTwoFA(): ?LoginMechanisms
    {
        return LoginMechanisms::where('iam_user_id', $this->_user->id)
            ->where('login_mechanism', 'ilike', '2FA%')
            ->where('is_latest', 1)
            ->where('is_active', 1)
            ->first();
    }

    /**
     * Set password for a user by creating or updating a password-based login mechanism
     *
     * Features:
     * - Validates current password if provided
     * - Hashes password using configured algorithm (Argon2id/bcrypt)
     * - Stores password history (updated_at timestamp)
     * - Supports multiple mechanism types
     * - Updates existing mechanism or creates new one
     *
     * @param array $data The data containing password and optional current_password
     * @param string $mechanismName The name of the login mechanism (default: 'password')
     * @return LoginMechanisms The created or updated login mechanism
     * @throws UnauthorizedException If current password verification fails
     * @throws \Exception
     */
    public function setPassword(array $data, string $mechanismName = 'password'): LoginMechanisms
    {
        $password = $data['password'];
        $currentPassword = $data['current_password'] ?? null;

        // If the current password is provided, verify it first
        if ($currentPassword && !$this->verifyPassword($currentPassword, $mechanismName)) {
            throw new UnauthorizedException('Current password is incorrect.');
        }

        // Hash the password using the configured algorithm
        $hashedPassword = $this->hashPassword($password);

        // Check if a password mechanism already exists for this user
        $existingMechanism = LoginMechanisms::withoutGlobalScopes()
            ->where('iam_user_id', $this->_user->id)
            ->where('login_mechanism', $mechanismName)
            ->where('is_active', 1)
            ->first();

        if ($existingMechanism) {
            // Update existing mechanism with new password
            $loginData = $existingMechanism->login_data ?? [];

            // Store previous password hash in history (optional, for security audit)
            if (isset($loginData['password'])) {
                $loginData['previous_password'] = $loginData['password'];
                $loginData['previous_password_updated_at'] = $loginData['password_updated_at'] ?? null;
            }

            $loginData['password'] = $hashedPassword;
            $loginData['password_updated_at'] = now()->toDateTimeString();

            $existingMechanism->login_data = $loginData;
            $existingMechanism->is_latest = true;
            $existingMechanism->save();

            return $existingMechanism->fresh();
        }

        // Create a new password mechanism
        return self::create([
            'iam_user_id' => $this->_user->id,
            'login_mechanism' => $mechanismName,
            'login_data' => [
                'password' => $hashedPassword,
                'password_created_at' => now()->toDateTimeString(),
            ],
            'is_latest' => true,
            'is_default' => true,
            'is_active' => true,
        ]);
    }

    /**
     * Hash a password using the configured hashing algorithm
     *
     * @param string $password Plain text password
     * @return string Hashed password
     */
    protected function hashPassword(string $password): string
    {
        $algo = $this->getAvailableHashAlgorithm();
        return password_hash($password, $algo);
    }

    /**
     * Get the available hash algorithm from configuration
     *
     * @return int|string Password hash algorithm constant
     */
    protected function getAvailableHashAlgorithm(): int|string
    {
        $hashes = config('iam.hash_algorithms');

        // Return the first configured algorithm, or default to PASSWORD_DEFAULT
        if ($hashes && is_array($hashes) && count($hashes) > 0) {
            return $hashes[0];
        }

        // Default to bcrypt if no configuration
        return PASSWORD_BCRYPT;
    }

    /**
     * Verify a password against the stored hash
     *
     * This method checks if the provided plain text password matches the stored hash.
     * It also checks if the password needs rehashing (for security upgrades).
     *
     * @param string $password Plain text password to verify
     * @param string $mechanismName The name of the login mechanism (default: 'password')
     * @return bool True if the password matches, false otherwise
     */
    public function verifyPassword(string $password, string $mechanismName = 'password'): bool
    {
        $mechanism = LoginMechanisms::withoutGlobalScopes()
            ->where('iam_user_id', $this->_user->id)
            ->where('login_mechanism', $mechanismName)
            ->where('is_active', 1)
            ->first();

        if (!$mechanism) {
            return false;
        }

        $loginData = $mechanism->login_data ?? [];
        $hashedPassword = $loginData['password'] ?? null;

        if (!$hashedPassword) {
            return false;
        }

        $isValid = password_verify($password, $hashedPassword);

        // Check if the password needs rehashing (algorithm upgrade)
        if ($isValid && password_needs_rehash($hashedPassword, $this->getAvailableHashAlgorithm())) {
            // Rehash the password with the new algorithm
            $loginData['password'] = $this->hashPassword($password);
            $loginData['password_rehashed_at'] = now()->toDateTimeString();
            $mechanism->login_data = $loginData;
            $mechanism->save();
        }

        return $isValid;
    }

    /**
     * Check if a user has a password set for the given mechanism
     *
     * @param string $mechanismName The name of the login mechanism (default: 'password')
     * @return bool True if a password exists, false otherwise
     */
    public function hasPassword(string $mechanismName = 'password'): bool
    {
        $mechanism = LoginMechanisms::withoutGlobalScopes()
            ->where('iam_user_id', $this->_user->id)
            ->where('login_mechanism', $mechanismName)
            ->where('is_active', 1)
            ->first();

        if (!$mechanism) {
            return false;
        }

        $loginData = $mechanism->login_data ?? [];
        return !empty($loginData['password']);
    }

    /**
     * Get password metadata (age, last updated, etc.)
     *
     * @param string $mechanismName The name of the login mechanism (default: 'password')
     * @return array|null Password metadata or null if not found
     */
    public function getPasswordMetadata(string $mechanismName = 'password'): ?array
    {
        $mechanism = LoginMechanisms::withoutGlobalScopes()
            ->where('iam_user_id', $this->_user->id)
            ->where('login_mechanism', $mechanismName)
            ->where('is_active', 1)
            ->first();

        if (!$mechanism) {
            return null;
        }

        $loginData = $mechanism->login_data ?? [];

        return [
            'has_password' => !empty($loginData['password']),
            'created_at' => $loginData['password_created_at'] ?? null,
            'updated_at' => $loginData['password_updated_at'] ?? null,
            'rehashed_at' => $loginData['password_rehashed_at'] ?? null,
            'mechanism_name' => $mechanismName,
        ];
    }
}
