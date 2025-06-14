<?php

namespace NextDeveloper\IAM\Http\Controllers\Users;

use Illuminate\Http\Request;
use NextDeveloper\Commons\Http\Controllers\AbstractController;
use NextDeveloper\Commons\Http\Response\ResponsableFactory;
use NextDeveloper\IAM\Database\Filters\UsersQueryFilter;
use NextDeveloper\IAM\Database\Models\UsersPerspective;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Helpers\UserHelper;
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

        $me = UsersPerspective::withoutGlobalScope(AuthorizationScope::class)
            ->where('id', $me->id)
            ->first();

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
