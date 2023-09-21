<?php

namespace NextDeveloper\IAM\Http\Requests\RolePermissions;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class RolePermissionsCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'iam_role_id'       => 'required|exists:iam_roles,uuid|uuid',
        'iam_permission_id' => 'required|exists:iam_permissions,uuid|uuid',
        'is_active'         => 'boolean',
        'created_by'        => 'nullable|integer',
        'updated_by'        => 'nullable|integer',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}