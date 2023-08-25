<?php

namespace NextDeveloper\IAM\Http\Requests\IamAccountUser;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class IamAccountUserUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules() {
        return [
            'iam_user_id'    => 'nullable|exists:iam_users,uuid|uuid',
			'iam_account_id' => 'nullable|exists:iam_accounts,uuid|uuid',
			'is_active'      => 'boolean',
			'session_data'   => 'nullable',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}