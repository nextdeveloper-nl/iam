<?php

namespace NextDeveloper\IAM\Http\Controllers\IamUser;

use Illuminate\Http\Request;
use Laravel\Passport\Bridge\User;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Http\Requests\IamUser\IamUserUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamUserQueryFilter;
use NextDeveloper\IAM\Services\IamUserService;
use NextDeveloper\IAM\Http\Requests\IamUser\IamUserCreateRequest;

class IamMyUserController extends AbstractController
{
    /**
    * This method returns the information of the user
    *
    * @param IamUserQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamUserQueryFilter $filter, Request $request) {
        $me = UserHelper::me();

        return ResponsableFactory::makeResponse($this, $me);
    }

    /**
     * Updates the logged-in user information
     *
     * @param IamUserUpdateRequest $request
     * @return mixed|null
     * @throws \Exception
     */
    public function update(IamUserUpdateRequest $request) {
        $user = UserHelper::me();

        return ResponsableFactory::makeResponse($this, IamUserService::update($user->uuid, $request->validated()));
    }
}