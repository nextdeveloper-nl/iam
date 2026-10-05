<?php

namespace NextDeveloper\IAM\Http\Requests\Authentication;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;
use NextDeveloper\IAM\Helpers\UserHelper;

class QrBadgeRequest extends AbstractFormRequest
{
    /**
     * The token is checked here, before the controller, so anonymous callers get a 401.
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
        return [];
    }
}
