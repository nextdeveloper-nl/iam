<?php

namespace NextDeveloper\IAM\Http\Requests\Permissions;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class PermissionsCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'namespace' => 'nullable|string',
        'service' => 'nullable|string',
        'method' => 'required|string',
        'name' => 'nullable|string',
        'is_active' => 'boolean',
        'created_by' => 'required|integer',
        'updated_by' => 'nullable|integer',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n
}