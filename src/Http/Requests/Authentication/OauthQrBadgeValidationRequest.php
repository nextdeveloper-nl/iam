<?php

namespace NextDeveloper\IAM\Http\Requests\Authentication;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class OauthQrBadgeValidationRequest extends AbstractFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            //  The scanned QR content, e.g. FLQR1:<secret>.
            'badge' => 'required|string|max:255',
        ];
    }
}
