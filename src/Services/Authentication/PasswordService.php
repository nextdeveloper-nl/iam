<?php

namespace NextDeveloper\IAM\Services\Authentication;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use NextDeveloper\IAM\AuthenticationGrants\Password;
use NextDeveloper\IAM\Database\Models\AccountUsers;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Helpers\UserHelper;

class PasswordService
{
    /**
     * Whether an admin may manage the sign-in credentials (password, QR badge) of this user from the current
     * account. False when the user is also linked to any other account: the credentials would then change
     * the sign-in of someone who belongs to other tenants too. Used by the users transformer (can_* flags) and
     * by the password / QR badge controllers (424 with a clear reason).
     */
    public static function canManageCredentials(Users $user): bool
    {
        $currentAccount = UserHelper::currentAccount();

        //  Any membership (active or pending) that is not the current account makes the user shared
        return ! AccountUsers::withoutGlobalScopes()
            ->where('iam_user_id', $user->id)
            ->when($currentAccount, fn ($q) => $q->where('iam_account_id', '!=', $currentAccount->id))
            ->exists();
    }

    /**
     * Changes the password of the signed in user. When the user already has a password, the current
     * one has to be given; a user who signed in with an e-mail code can set a first password without it.
     *
     * @throws ValidationException When the current password is missing or wrong.
     */
    public static function updatePassword(string $password, ?string $currentPassword = null): bool
    {
        $user = UserHelper::me();

        if (Password::hasPassword($user)) {
            $mechanism = Password::findMechanism($user);

            if (!$currentPassword || !(new Password())->attempt($mechanism, $currentPassword)) {
                throw ValidationException::withMessages([
                    'current_password' => 'The current password is not correct.',
                ]);
            }
        }

        return (new Password())->update($user, $password);
    }

    /**
     * Sets the password of any user, for administrators and console commands. A password is generated
     * when none is given. The user's access tokens are revoked so old sessions have to sign in again.
     *
     * @return string The password that was set.
     */
    public static function setPassword(Users $user, ?string $password = null, bool $revokeTokens = true): string
    {
        $password = $password ?: Password::generateStrongPassword();

        (new Password())->update($user, $password);

        if ($revokeTokens) {
            DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();
        }

        return $password;
    }
}
