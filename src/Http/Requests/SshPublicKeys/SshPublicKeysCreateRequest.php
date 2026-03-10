<?php

namespace NextDeveloper\IAM\Http\Requests\SshPublicKeys;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

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
}