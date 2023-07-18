<?php

namespace NextDeveloper\IAM\Http\Controllers\IamPermission;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\IamPermission\IamPermissionUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamPermissionQueryFilter;
use NextDeveloper\IAM\Services\IamPermissionService;
use NextDeveloper\IAM\Http\Requests\IamPermission\IamPermissionCreateRequest;

class IamPermissionController extends AbstractController
{
    /**
    * This method returns the list of iampermissions.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamPermissionQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamPermissionQueryFilter $filter, Request $request) {
        $data = IamPermissionService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $iamPermissionId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = IamPermissionService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created IamPermission object on database.
    *
    * @param IamPermissionCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(IamPermissionCreateRequest $request) {
        $model = IamPermissionService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamPermission object on database.
    *
    * @param $iamPermissionId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($iamPermissionId, IamPermissionUpdateRequest $request) {
        $model = IamPermissionService::update($iamPermissionId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamPermission object on database.
    *
    * @param $iamPermissionId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($iamPermissionId) {
        $model = IamPermissionService::delete($iamPermissionId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}