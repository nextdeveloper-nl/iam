<?php

namespace NextDeveloper\IAM\Http\Requests\Authentication;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class OauthPasswordResetRequest extends AbstractFormRequest
{
    /**
     * Same rules as a signed in user changing their password (PasswordUpdateRequest).
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password'  => 'required|string|min:8|max:255|confirmed',
        ];
    }
}
