<?php

namespace NextDeveloper\IAM\Http\Controllers\IamRolePermission;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\IamRolePermission\IamRolePermissionUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamRolePermissionQueryFilter;
use NextDeveloper\IAM\Services\IamRolePermissionService;
use NextDeveloper\IAM\Http\Requests\IamRolePermission\IamRolePermissionCreateRequest;

class IamRolePermissionController extends AbstractController
{
    /**
    * This method returns the list of iamrolepermissions.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamRolePermissionQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamRolePermissionQueryFilter $filter, Request $request) {
        $data = IamRolePermissionService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $iamRolePermissionId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = IamRolePermissionService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created IamRolePermission object on database.
    *
    * @param IamRolePermissionCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(IamRolePermissionCreateRequest $request) {
        $model = IamRolePermissionService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamRolePermission object on database.
    *
    * @param $iamRolePermissionId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($iamRolePermissionId, IamRolePermissionUpdateRequest $request) {
        $model = IamRolePermissionService::update($iamRolePermissionId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamRolePermission object on database.
    *
    * @param $iamRolePermissionId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($iamRolePermissionId) {
        $model = IamRolePermissionService::delete($iamRolePermissionId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}