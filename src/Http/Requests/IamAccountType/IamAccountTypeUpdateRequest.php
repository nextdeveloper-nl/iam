<?php

namespace NextDeveloper\IAM\Http\Requests\IamAccountType;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class IamAccountTypeUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules() {
        return [
            'name'        => 'nullable|string|max:20',
			'description' => 'nullable|string|max:255',
			'country_id'  => 'nullable|exists:countries,uuid|uuid',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}