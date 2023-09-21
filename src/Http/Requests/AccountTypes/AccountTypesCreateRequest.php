<?php

namespace NextDeveloper\IAM\Http\Requests\AccountTypes;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class AccountTypesCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required|string|max:20',
        'description'       => 'nullable|string|max:255',
        'common_country_id' => 'required|exists:common_countries,uuid|uuid',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}