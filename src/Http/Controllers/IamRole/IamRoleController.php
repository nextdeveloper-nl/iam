<?php

namespace NextDeveloper\IAM\Http\Controllers\IamRole;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\IamRole\IamRoleUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamRoleQueryFilter;
use NextDeveloper\IAM\Services\IamRoleService;
use NextDeveloper\IAM\Http\Requests\IamRole\IamRoleCreateRequest;

class IamRoleController extends AbstractController
{
    /**
    * This method returns the list of iamroles.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamRoleQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamRoleQueryFilter $filter, Request $request) {
        $data = IamRoleService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $iamRoleId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = IamRoleService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created IamRole object on database.
    *
    * @param IamRoleCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(IamRoleCreateRequest $request) {
        $model = IamRoleService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamRole object on database.
    *
    * @param $iamRoleId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($iamRoleId, IamRoleUpdateRequest $request) {
        $model = IamRoleService::update($iamRoleId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamRole object on database.
    *
    * @param $iamRoleId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($iamRoleId) {
        $model = IamRoleService::delete($iamRoleId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}