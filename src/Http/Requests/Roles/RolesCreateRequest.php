<?php

namespace NextDeveloper\IAM\Http\Requests\Roles;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class RolesCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
        'class' => 'nullable|string',
        'level' => 'required|integer',
        'description' => 'nullable|string',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n
}