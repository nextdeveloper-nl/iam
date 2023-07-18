<?php

namespace NextDeveloper\IAM\Http\Requests\IamRoleUser;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class IamRoleUserCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules() {
        return [
            'account_role_id' => 'required|exists:account_roles,uuid|uuid',
			'user_id'         => 'required|exists:users,uuid|uuid',
			'account_id'      => 'nullable|exists:accounts,uuid|uuid',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}