<?php

namespace NextDeveloper\IAM\Http\Requests\UserRoles;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class UserRolesUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string',
        'class' => 'nullable|string',
        'level' => 'nullable|integer',
        'description' => 'nullable|string',
        'iam_role_id' => 'nullable|exists:iam_roles,uuid|uuid',
        'is_active' => 'nullable|boolean',
        'role_data' => 'nullable',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}