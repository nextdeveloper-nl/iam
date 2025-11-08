<?php

namespace NextDeveloper\IAM\Http\Requests\Authentication;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class OauthUsernamePasswordLoginRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'username'     => 'string',
            'password' => 'string',
            'code'  => 'string'
        ];
    }
}
