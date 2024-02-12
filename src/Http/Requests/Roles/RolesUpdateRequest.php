<?php

namespace NextDeveloper\IAM\Http\Requests\Roles;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class RolesUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string',
        'class' => 'nullable|string',
        'level' => 'nullable|integer',
        'description' => 'nullable|string',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n
}