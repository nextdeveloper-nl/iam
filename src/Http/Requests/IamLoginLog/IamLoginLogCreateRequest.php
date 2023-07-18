<?php

namespace NextDeveloper\IAM\Http\Requests\IamLoginLog;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class IamLoginLogCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules() {
        return [
            'user_id' => 'nullable|exists:users,uuid|uuid',
			'log'     => 'nullable',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}