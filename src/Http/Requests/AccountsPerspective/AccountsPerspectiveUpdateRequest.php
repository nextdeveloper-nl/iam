<?php

namespace NextDeveloper\IAM\Http\Requests\AccountsPerspective;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class AccountsPerspectiveUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string',
        'description' => 'nullable|string',
        'phone_number' => 'nullable|string',
        'account_owner' => 'nullable|string',
        'account_type' => 'nullable|string',
        'is_active' => 'nullable|boolean',
        'tags' => 'nullable',
        'total_user_count' => 'nullable|integer',
        'registered_user_count' => 'nullable|integer',
        'domain_name' => 'nullable|string',
        'common_domain_id' => 'nullable|exists:common_domains,uuid|uuid',
        'country_name' => 'nullable|string',
        'profile_image_url' => 'nullable|string',
        'common_country_id' => 'nullable|exists:common_countries,uuid|uuid',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}