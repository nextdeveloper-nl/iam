<?php

namespace NextDeveloper\IAM\Helpers;

/**
 * Parses OpenSSH public keys ("<type> <base64 blob> [comment]") so they can be validated and so the
 * fingerprint / key_type columns can be derived instead of trusting client input.
 */
class SshPublicKeyHelper
{
    public const SUPPORTED_TYPES = [
        'ssh-rsa',
        'ssh-ed25519',
        'ssh-dss',
        'ecdsa-sha2-nistp256',
        'ecdsa-sha2-nistp384',
        'ecdsa-sha2-nistp521',
        'sk-ssh-ed25519@openssh.com',
        'sk-ecdsa-sha2-nistp256@openssh.com',
    ];

    /**
     * Returns ['key_type' => ..., 'fingerprint' => 'SHA256:...'] or null when the string is not a valid
     * OpenSSH public key. The type written in the text must match the type encoded inside the blob.
     *
     * @param  string $publicKey
     * @return array|null
     */
    public static function parse(string $publicKey): ?array
    {
        $parts = preg_split('/\s+/', trim($publicKey));

        if (count($parts) < 2 || !in_array($parts[0], self::SUPPORTED_TYPES, true)) {
            return null;
        }

        $blob = base64_decode($parts[1], true);

        if ($blob === false || strlen($blob) < 4) {
            return null;
        }

        // The blob starts with a 4 byte big-endian length followed by the key type string.
        $length = unpack('N', substr($blob, 0, 4))[1];

        if ($length <= 0 || strlen($blob) < 4 + $length || substr($blob, 4, $length) !== $parts[0]) {
            return null;
        }

        return [
            'key_type'    => $parts[0],
            'fingerprint' => 'SHA256:' . rtrim(base64_encode(hash('sha256', $blob, true)), '='),
        ];
    }
}
