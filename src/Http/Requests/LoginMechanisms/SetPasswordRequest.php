<?php

namespace NextDeveloper\IAM\Http\Requests\LoginMechanisms;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

/**
 * Class SetPasswordRequest
 *
 * Request validation for setting user passwords.
 * Supports both admin setting passwords for users and users changing their own passwords.
 *
 * @package NextDeveloper\IAM\Http\Requests\LoginMechanisms
 */
class SetPasswordRequest extends AbstractFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'string'],
            'current_password' => 'nullable|string',
            'mechanism_name' => 'nullable|string|max:255',
        ];
    }
}
