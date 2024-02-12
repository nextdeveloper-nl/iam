<?php

namespace NextDeveloper\IAM\Http\Requests\Accounts;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class AccountsCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
        'common_domain_id' => 'nullable|exists:common_domains,uuid|uuid',
        'common_country_id' => 'nullable|exists:common_countries,uuid|uuid',
        'phone_number' => 'nullable',
        'description' => 'nullable|string',
        'iam_account_type_id' => 'required|exists:iam_account_types,uuid|uuid',
        'is_active' => 'boolean',
        'tags' => '',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}