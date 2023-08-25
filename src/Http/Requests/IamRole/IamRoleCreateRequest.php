<?php

namespace NextDeveloper\IAM\Http\Requests\IamRole;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class IamRoleCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules() {
        return [
            'name'        => 'required|string|max:50',
			'class'       => 'nullable|string|max:500',
			'level'       => 'required|boolean',
			'description' => 'nullable|string',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}