<?php

namespace NextDeveloper\IAM\Http\Requests\IamUserRoleOverview;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class IamUserRoleOverviewCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules() {
        return [
            'name'        => 'required|string|max:50',
			'class'       => 'nullable|string|max:500',
			'level'       => 'required|boolean',
			'description' => 'nullable|string',
			'iam_role_id'     => 'required|exists:roles,uuid|uuid',
			'iam_user_id'     => 'required|exists:users,uuid|uuid',
			'iam_account_id'  => 'nullable|exists:accounts,uuid|uuid',
			'is_active'   => 'boolean',
			'role_data'   => 'nullable',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}