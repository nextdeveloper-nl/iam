<?php

namespace NextDeveloper\IAM\Http\Controllers\IamAccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\IamAccount\IamAccountUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamAccountQueryFilter;
use NextDeveloper\IAM\Services\IamAccountService;
use NextDeveloper\IAM\Http\Requests\IamAccount\IamAccountCreateRequest;

class IamAccountController extends AbstractController
{
    /**
    * This method returns the list of iamaccounts.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamAccountQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamAccountQueryFilter $filter, Request $request) {
        $data = IamAccountService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $iamAccountId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = IamAccountService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created IamAccount object on database.
    *
    * @param IamAccountCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(IamAccountCreateRequest $request) {
        $model = IamAccountService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamAccount object on database.
    *
    * @param $iamAccountId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($iamAccountId, IamAccountUpdateRequest $request) {
        $model = IamAccountService::update($iamAccountId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamAccount object on database.
    *
    * @param $iamAccountId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($iamAccountId) {
        $model = IamAccountService::delete($iamAccountId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}