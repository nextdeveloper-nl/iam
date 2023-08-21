<?php

namespace NextDeveloper\IAM\Http\Requests\IamLoginLog;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class IamLoginLogUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules() {
        return [
            'iam_user_id' => 'nullable|exists:iam_users,uuid|uuid',
			'log'         => 'nullable',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}