<?php

namespace NextDeveloper\IAM\Http\Controllers\Authentication;

use App\Helpers\Http\ResponseHelper;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\IAM\Http\Requests\AccountUsersPerspective\AccountUsersPerspectiveCreateRequest;
use NextDeveloper\IAM\Http\Requests\AccountUsersPerspective\AccountUsersPerspectiveUpdateRequest;
use NextDeveloper\IAM\Http\Requests\Authentication\GetLoginMechanismsRequest;
use NextDeveloper\IAM\Services\LoginMechanismsService;

class LoginMechanismsController extends AbstractController
{
    public function index(GetLoginMechanismsRequest $request)
    {
        $user = null;

        if($request->has('email'))
            $user = UserHelper::getWithEmail($request->validated('email'));

        if($request->has('username'))
            $user = UserHelper::getWithUsername($request->validated('username'));

        return ResponseHelper::data(
            LoginMechanismsService::get
        );
    }
}
