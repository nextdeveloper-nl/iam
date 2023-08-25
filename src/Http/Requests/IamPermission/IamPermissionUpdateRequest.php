<?php

namespace NextDeveloper\IAM\Http\Requests\IamPermission;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class IamPermissionUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules() {
        return [
            'namespace'  => 'nullable|string|max:500',
			'service'    => 'nullable|string|max:255',
			'method'     => 'nullable|string|max:255',
			'name'       => 'nullable|string|max:255',
			'is_active'  => 'boolean',
			'created_by' => 'nullable|integer',
			'updated_by' => 'nullable|integer',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}