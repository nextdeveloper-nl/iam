<?php

namespace NextDeveloper\IAM\Http\Controllers\RolePermissions;

use Illuminate\Http\Request;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\RolePermissions\RolePermissionsUpdateRequest;
use NextDeveloper\IAM\Database\Filters\RolePermissionsQueryFilter;
use NextDeveloper\IAM\Services\RolePermissionsService;
use NextDeveloper\IAM\Http\Requests\RolePermissions\RolePermissionsCreateRequest;

class RolePermissionsController extends AbstractController
{
    /**
    * This method returns the list of rolepermissions.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param RolePermissionsQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(RolePermissionsQueryFilter $filter, Request $request) {
        $data = RolePermissionsService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $rolePermissionsId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = RolePermissionsService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created RolePermissions object on database.
    *
    * @param RolePermissionsCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(RolePermissionsCreateRequest $request) {
        $model = RolePermissionsService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates RolePermissions object on database.
    *
    * @param $rolePermissionsId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($rolePermissionsId, RolePermissionsUpdateRequest $request) {
        $model = RolePermissionsService::update($rolePermissionsId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates RolePermissions object on database.
    *
    * @param $rolePermissionsId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($rolePermissionsId) {
        $model = RolePermissionsService::delete($rolePermissionsId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}