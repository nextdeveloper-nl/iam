<?php

namespace NextDeveloper\IAM\Http\Requests\LoginMechanisms;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class LoginMechanismsCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'login_client'    => 'nullable|string|max:1000',
        'login_data'      => 'nullable',
        'login_mechanism' => 'nullable|string|max:50',
        'is_latest'       => 'boolean',
        'is_default'      => 'boolean',
        'is_active'       => 'boolean',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n
}