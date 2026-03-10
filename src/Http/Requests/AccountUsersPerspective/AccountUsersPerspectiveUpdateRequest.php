<?php

namespace NextDeveloper\IAM\Http\Requests\AccountUsersPerspective;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class AccountUsersPerspectiveUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string',
        'surname' => 'nullable|string',
        'email' => 'nullable|string',
        'fullname' => 'nullable|string',
        'username' => 'nullable|string',
        'about' => 'nullable|string',
        'pronoun' => 'nullable|string',
        'birthday' => 'nullable|date',
        'nin' => 'nullable|string',
        'common_language_id' => 'nullable|exists:common_languages,uuid|uuid',
        'common_country_id' => 'nullable|exists:common_countries,uuid|uuid',
        'phone_number' => 'nullable|string',
        'is_active' => 'nullable|boolean',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}