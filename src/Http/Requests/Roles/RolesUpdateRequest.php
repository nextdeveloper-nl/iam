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
            'name'        => 'nullable|string|max:50',
        'class'       => 'nullable|string|max:500',
        'level'       => 'nullable|boolean',
        'description' => 'nullable|string',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n
}