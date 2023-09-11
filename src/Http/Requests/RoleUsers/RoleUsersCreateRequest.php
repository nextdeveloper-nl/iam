<?php

namespace NextDeveloper\IAM\Http\Requests\RoleUsers;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class RoleUsersCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'iam_role_id'    => 'required|exists:iam_roles,uuid|uuid',
        'iam_user_id'    => 'required|exists:iam_users,uuid|uuid',
        'iam_account_id' => 'nullable|exists:iam_accounts,uuid|uuid',
        'is_active'      => 'boolean',
        'role_data'      => 'nullable',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}