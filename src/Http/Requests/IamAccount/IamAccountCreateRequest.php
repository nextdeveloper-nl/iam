<?php

namespace NextDeveloper\IAM\Http\Requests\IamAccount;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class IamAccountCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules() {
        return [
            'name'            => 'nullable|string|max:500',
			'domain_id'       => 'nullable|exists:domains,uuid|uuid',
			'country_id'      => 'nullable|exists:countries,uuid|uuid',
			'currency_id'     => 'nullable|exists:currencies,uuid|uuid',
			'phone_number'    => 'nullable|string|max:20',
			'description'     => 'nullable|string|max:500',
			'owner_id'        => 'required|exists:owners,uuid|uuid',
			'account_type_id' => 'exists:account_types,uuid|uuid',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}