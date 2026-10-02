<?php

namespace NextDeveloper\IAM\AuthenticationGrants;

use Illuminate\Support\Facades\DB;
use NextDeveloper\Events\Services\Events;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Database\Models\Users;

/**
 * Sign-in with a printed QR badge: the badge carries a long random secret, scanning it signs the
 * user in without a username or password. Only a SHA-256 of the secret is stored (the secret has
 * 256 bits of entropy, so a slow hash adds nothing, and the hash has to be looked up by value).
 *
 * A user has at most one badge. Issuing a new one replaces the old; revoking removes it.
 */
class QrBadge
{
    const LOGINNAME = 'QrBadge';

    /**
     * Prefix of the QR content, so a scanner can tell a sign-in badge from other QR codes
     * (station cards) and a future format can be told apart.
     */
    const PREFIX = 'FLQR1:';

    /**
     * Issues a new badge for the user, replacing any previous one, and returns the QR content.
     * The content is not stored and cannot be shown again.
     */
    public static function issue(Users $user): string
    {
        $secret = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');

        $data = [
            'tokenHash' => self::hash($secret),
            'issued_at' => now()->toDateTimeString(),
        ];

        $mechanism = self::findMechanism($user);

        if ($mechanism) {
            $mechanism->update([
                'login_data' => $data,
                'is_active' => true,
                'is_latest' => true,
            ]);
        } else {
            $mechanism = LoginMechanisms::create([
                'iam_user_id' => $user->id,
                'login_mechanism' => self::LOGINNAME,
                'login_data' => $data,
                'is_latest' => true,
                'is_default' => false,
                'is_active' => true,
            ]);
        }

        Events::fire('updated:NextDeveloper\IAM\LoginMechanisms', $mechanism);

        return self::PREFIX . $secret;
    }

    /**
     * Removes the user's badge. Returns whether there was one.
     */
    public static function revoke(Users $user): bool
    {
        $mechanism = self::findMechanism($user);

        if (!$mechanism) {
            return false;
        }

        $mechanism->delete();

        return true;
    }

    public static function hasBadge(Users $user): bool
    {
        $mechanism = self::findMechanism($user);

        return $mechanism && $mechanism->is_active && !empty($mechanism->login_data['tokenHash']);
    }

    /**
     * The user the scanned QR content belongs to, or null for unknown, revoked or malformed content.
     */
    public static function userFor(string $content): ?Users
    {
        $content = trim($content);

        if (!str_starts_with($content, self::PREFIX)) {
            return null;
        }

        $secret = substr($content, strlen(self::PREFIX));

        if (strlen($secret) < 32) {
            return null;
        }

        $userId = LoginMechanisms::withoutGlobalScopes()
            ->where('login_mechanism', self::LOGINNAME)
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->where(DB::raw("login_data->>'tokenHash'"), self::hash($secret))
            ->value('iam_user_id');

        if (!$userId) {
            return null;
        }

        return Users::withoutGlobalScopes()
            ->where('id', $userId)
            ->whereNull('deleted_at')
            ->first();
    }

    public static function findMechanism(Users $user): ?LoginMechanisms
    {
        return LoginMechanisms::withoutGlobalScopes()
            ->where('iam_user_id', $user->id)
            ->where('login_mechanism', self::LOGINNAME)
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->first();
    }

    private static function hash(string $secret): string
    {
        return hash('sha256', $secret);
    }
}
