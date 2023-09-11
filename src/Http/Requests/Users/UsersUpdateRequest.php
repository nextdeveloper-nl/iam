<?php

namespace NextDeveloper\IAM\Http\Requests\Users;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class UsersUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name'               => 'nullable|string|max:50',
        'surname'            => 'nullable|string|max:50',
        'email'              => 'nullable|string|max:255',
        'fullname'           => 'nullable|string|max:100',
        'username'           => 'nullable|string|max:50',
        'about'              => 'nullable|string',
        'pronoun'            => 'nullable|string|max:100',
        'birthday'           => 'nullable|date',
        'nin'                => 'nullable|string|max:30',
        'cell_phone'         => 'nullable|string|max:15',
        'common_language_id' => 'exists:common_languages,uuid|uuid',
        'common_country_id'  => 'exists:common_countries,uuid|uuid',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}