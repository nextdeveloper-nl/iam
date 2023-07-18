<?php

namespace NextDeveloper\IAM\Http\Controllers\IamRoleUser;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\IamRoleUser\IamRoleUserUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamRoleUserQueryFilter;
use NextDeveloper\IAM\Services\IamRoleUserService;
use NextDeveloper\IAM\Http\Requests\IamRoleUser\IamRoleUserCreateRequest;

class IamRoleUserController extends AbstractController
{
    /**
    * This method returns the list of iamroleusers.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamRoleUserQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamRoleUserQueryFilter $filter, Request $request) {
        $data = IamRoleUserService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $iamRoleUserId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = IamRoleUserService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created IamRoleUser object on database.
    *
    * @param IamRoleUserCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(IamRoleUserCreateRequest $request) {
        $model = IamRoleUserService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamRoleUser object on database.
    *
    * @param $iamRoleUserId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($iamRoleUserId, IamRoleUserUpdateRequest $request) {
        $model = IamRoleUserService::update($iamRoleUserId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamRoleUser object on database.
    *
    * @param $iamRoleUserId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($iamRoleUserId) {
        $model = IamRoleUserService::delete($iamRoleUserId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}