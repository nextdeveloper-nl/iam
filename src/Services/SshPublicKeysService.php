<?php

namespace NextDeveloper\IAM\Services;

use NextDeveloper\Commons\Exceptions\CannotCreateModelException;
use NextDeveloper\IAM\Database\Models\SshPublicKeys;
use NextDeveloper\IAM\Helpers\SshPublicKeyHelper;
use NextDeveloper\IAM\Services\AbstractServices\AbstractSshPublicKeysService;

/**
 * This class is responsible from managing the data for SshPublicKeys
 *
 * Class SshPublicKeysService.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class SshPublicKeysService extends AbstractSshPublicKeysService
{
    /**
     * Derives fingerprint and key_type from the public key itself (client supplied values are ignored)
     * and rejects keys that are not valid OpenSSH public keys.
     *
     * @param  array $data
     * @return SshPublicKeys
     */
    public static function create(array $data)
    {
        $parsed = SshPublicKeyHelper::parse((string) ($data['public_key'] ?? ''));

        if ($parsed === null) {
            throw new CannotCreateModelException(
                'The public key must be a valid OpenSSH public key (type followed by a base64 blob).'
            );
        }

        $data['key_type'] = $parsed['key_type'];
        $data['fingerprint'] = $parsed['fingerprint'];

        return parent::create($data);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}