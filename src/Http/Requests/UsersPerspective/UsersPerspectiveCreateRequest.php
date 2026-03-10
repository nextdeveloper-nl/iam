<?php

namespace NextDeveloper\IAM\Http\Requests\UsersPerspective;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class UsersPerspectiveCreateRequest extends AbstractFormRequest
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
        'common_country_id' => 'nullable|exists:common_countries,uuid|uuid',
        'country' => 'nullable|string',
        'common_language_id' => 'nullable|exists:common_languages,uuid|uuid',
        'language' => 'nullable|string',
        'phone_number' => 'nullable|string',
        'tags' => 'nullable',
        'roles' => 'nullable',
        'profile_picture' => 'nullable|string',
        'has_valid_google_login' => 'nullable|boolean',
        'is_registered' => 'nullable|boolean',
        'is_active' => 'nullable|boolean',
        'is_nin_verified' => 'nullable|boolean',
        'is_email_verified' => 'nullable|boolean',
        'is_phone_number_verified' => 'nullable|boolean',
        'is_profile_verified' => 'nullable|boolean',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}