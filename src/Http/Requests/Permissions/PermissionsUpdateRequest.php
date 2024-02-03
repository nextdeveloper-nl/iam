<?php

namespace NextDeveloper\IAM\Http\Requests\Permissions;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class PermissionsUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'namespace' => 'nullable|string',
        'service' => 'nullable|string',
        'method' => 'nullable|string',
        'name' => 'nullable|string',
        'is_active' => 'boolean',
        'created_by' => 'nullable|integer',
        'updated_by' => 'nullable|integer',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n
}