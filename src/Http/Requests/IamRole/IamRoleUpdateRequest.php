<?php

namespace NextDeveloper\IAM\Http\Requests\IamRole;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class IamRoleUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules() {
        return [
            'name'        => 'nullable|string|max:50',
			'class'       => 'nullable|string|max:500',
			'level'       => 'nullable|boolean',
			'description' => 'nullable|string',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}