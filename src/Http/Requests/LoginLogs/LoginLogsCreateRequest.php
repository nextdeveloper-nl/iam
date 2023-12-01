<?php

namespace NextDeveloper\IAM\Http\Requests\LoginLogs;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class LoginLogsCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'log'         => 'nullable',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}