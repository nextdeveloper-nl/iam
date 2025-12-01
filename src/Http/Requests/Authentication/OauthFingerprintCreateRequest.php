<?php

namespace NextDeveloper\IAM\Http\Requests\Authentication;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class OauthFingerprintCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'user_agent'        => 'string',
            'platform'          => 'string',
            'fingerprint'       => 'string',
            'ip_address'        => 'string',
            'language'          => 'string',
            'timezone_offset'   => 'string',
            'screen_color_depth'=> 'string',
        ];
    }
}
