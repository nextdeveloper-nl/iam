<?php

namespace NextDeveloper\IAM\Http\Requests\SshPublicKeys;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;
use NextDeveloper\IAM\Helpers\SshPublicKeyHelper;

class SshPublicKeysCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
        'public_key' => 'required|string',
        'fingerprint' => 'nullable|string',
        'key_type' => 'nullable|string',
        'scope' => 'string',
        'is_active' => 'boolean',
        'tags' => 'nullable',
        'expires_at' => 'nullable|date',
        'last_used_at' => 'nullable|date',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    /**
     * Rejects public keys that are not valid OpenSSH keys with a 422 on the public_key field.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $key = $this->input('public_key');

            if (is_string($key) && SshPublicKeyHelper::parse($key) === null) {
                $validator->errors()->add(
                    'public_key',
                    'The public key must be a valid OpenSSH public key (type followed by a base64 blob).'
                );
            }
        });
    }
}