<?php

namespace NextDeveloper\IAM\Http\Requests\SshPublicKeyEvents;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class SshPublicKeyEventsUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'iam_ssh_public_key_id' => 'nullable|exists:iam_ssh_public_keys,uuid|uuid',
        'action' => 'nullable',
        'ip_addr' => 'nullable',
        'meta' => 'nullable',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}