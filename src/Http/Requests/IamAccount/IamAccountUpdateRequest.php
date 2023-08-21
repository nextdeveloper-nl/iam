<?php

namespace NextDeveloper\IAM\Http\Requests\IamAccount;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class IamAccountUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules() {
        return [
            'name'                => 'nullable|string|max:500',
			'common_domain_id'    => 'nullable|exists:common_domains,uuid|uuid',
			'common_country_id'   => 'nullable|exists:common_countries,uuid|uuid',
			'phone_number'        => 'nullable|string|max:20',
			'description'         => 'nullable|string|max:500',
			'iam_user_id'         => 'nullable|exists:iam_users,uuid|uuid',
			'iam_account_type_id' => 'exists:iam_account_types,uuid|uuid',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}