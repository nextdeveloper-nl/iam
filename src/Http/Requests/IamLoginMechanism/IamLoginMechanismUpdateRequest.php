<?php

namespace NextDeveloper\IAM\Http\Requests\IamLoginMechanism;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class IamLoginMechanismUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules() {
        return [
            'user_id'         => 'nullable|exists:users,uuid|uuid',
			'login_client'    => 'nullable|string|max:1000',
			'login_data'      => 'nullable',
			'login_mechanism' => 'nullable|string|max:50',
			'is_latest'       => 'boolean',
			'is_default'      => 'boolean',
			'is_active'       => 'boolean',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}