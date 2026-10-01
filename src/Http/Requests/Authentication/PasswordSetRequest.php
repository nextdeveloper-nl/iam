<?php

namespace NextDeveloper\IAM\Http\Requests\Authentication;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;
use NextDeveloper\IAM\Helpers\UserHelper;

class PasswordSetRequest extends AbstractFormRequest
{
    /**
     * The /iam/authentication prefix is skipped by the authentication middleware, so the
     * token is checked here, before the body is validated.
     */
    public function authorize()
    {
        return UserHelper::me() !== null;
    }

    protected function failedAuthorization()
    {
        abort(401, 'Unauthenticated');
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            //  When left out, a password is generated and returned once in the response.
            'password'  => 'nullable|string|min:8|max:255',
        ];
    }
}
