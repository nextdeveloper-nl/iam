<?php

namespace NextDeveloper\IAM\Http\Requests\IamRole;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class IamRoleCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules() {
        return [
            'name'        => 'required|string|max:255',
			'label'       => 'nullable|string|max:255',
			'level'       => 'required|boolean',
			'description' => 'nullable|string',
			'account_id'  => 'nullable|exists:accounts,uuid|uuid',
			'user_id'     => 'nullable|exists:users,uuid|uuid',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}