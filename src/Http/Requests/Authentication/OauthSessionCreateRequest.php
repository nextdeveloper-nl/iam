<?php

namespace NextDeveloper\IAM\Http\Requests\Authentication;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class OauthSessionCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'client_id'     => 'string',
            'client_secret' => 'string',
            'redirect_uri'  => 'string',
            'response_type' => 'in:code,token',
            'scope'         => 'string',
            'state'         => 'string',
        ];
    }
}
