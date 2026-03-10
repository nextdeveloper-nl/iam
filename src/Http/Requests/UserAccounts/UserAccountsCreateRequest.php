<?php

namespace NextDeveloper\IAM\Http\Requests\UserAccounts;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class UserAccountsCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string',
        'common_domain_id' => 'nullable|exists:common_domains,uuid|uuid',
        'common_country_id' => 'nullable|exists:common_countries,uuid|uuid',
        'is_active' => 'nullable|boolean',
        'session_data' => 'nullable',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}