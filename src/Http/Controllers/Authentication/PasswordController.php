<?php

namespace NextDeveloper\IAM\Http\Controllers\Authentication;

use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\IAM\Http\Requests\Authentication\PasswordUpdateRequest;
use NextDeveloper\IAM\Services\Authentication\PasswordService;

class PasswordController extends AbstractController
{
    public static function updatePassword(PasswordUpdateRequest $request)
    {
        PasswordService::updatePassword($request);
    }
}
