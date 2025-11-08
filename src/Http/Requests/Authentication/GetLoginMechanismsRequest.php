<?php

namespace NextDeveloper\IAM\Http\Requests\Authentication;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class GetLoginMechanismsRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'email',
            'username'  =>  'string',
        ];
    }
}
