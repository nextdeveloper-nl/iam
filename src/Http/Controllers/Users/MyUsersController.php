<?php

namespace NextDeveloper\IAM\Http\Controllers\Users;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Database\Filters\UsersQueryFilter;
use NextDeveloper\IAM\Http\Requests\Users\UsersUpdateRequest;
use NextDeveloper\IAM\Services\UsersService;

class MyUsersController extends AbstractController
{
    /**
     * This method returns the information of the user
     *
     * @param UsersQueryFilter $filter An object that builds search query
     * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UsersQueryFilter $filter, Request $request) {
        $me = UserHelper::me();

        return ResponsableFactory::makeResponse($this, $me);
    }

    /**
     * Updates the logged-in user information
     *
     * @param UsersUpdateRequest $request
     * @return mixed|null
     * @throws \Exception
     */
    public function update(UsersUpdateRequest $request) {
        $user = UserHelper::me();

        return ResponsableFactory::makeResponse($this, UsersService::update($user->uuid, $request->validated()));
    }
}