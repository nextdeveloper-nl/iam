<?php

namespace NextDeveloper\IAM\Http\Controllers\IamAccountType;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\IamAccountType\IamAccountTypeUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamAccountTypeQueryFilter;
use NextDeveloper\IAM\Services\IamAccountTypeService;
use NextDeveloper\IAM\Http\Requests\IamAccountType\IamAccountTypeCreateRequest;

class IamAccountTypeController extends AbstractController
{
    /**
    * This method returns the list of iamaccounttypes.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamAccountTypeQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamAccountTypeQueryFilter $filter, Request $request) {
        $data = IamAccountTypeService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $iamAccountTypeId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = IamAccountTypeService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created IamAccountType object on database.
    *
    * @param IamAccountTypeCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(IamAccountTypeCreateRequest $request) {
        $model = IamAccountTypeService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamAccountType object on database.
    *
    * @param $iamAccountTypeId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($iamAccountTypeId, IamAccountTypeUpdateRequest $request) {
        $model = IamAccountTypeService::update($iamAccountTypeId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamAccountType object on database.
    *
    * @param $iamAccountTypeId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($iamAccountTypeId) {
        $model = IamAccountTypeService::delete($iamAccountTypeId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}