<?php

namespace NextDeveloper\IAM\Http\Requests\IamRoleUser;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class IamRoleUserUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules() {
        return [
            'account_role_id' => 'nullable|exists:account_roles,uuid|uuid',
			'user_id'         => 'nullable|exists:users,uuid|uuid',
			'account_id'      => 'nullable|exists:accounts,uuid|uuid',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}