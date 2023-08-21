<?php

namespace NextDeveloper\IAM\Http\Controllers\IamViewUserAccount;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\IamViewUserAccount\IamViewUserAccountUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamViewUserAccountQueryFilter;
use NextDeveloper\IAM\Services\IamViewUserAccountService;
use NextDeveloper\IAM\Http\Requests\IamViewUserAccount\IamViewUserAccountCreateRequest;

class IamViewUserAccountController extends AbstractController
{
    /**
    * This method returns the list of iamviewuseraccounts.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamViewUserAccountQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamViewUserAccountQueryFilter $filter, Request $request) {
        $data = IamViewUserAccountService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $iamViewUserAccountId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = IamViewUserAccountService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created IamViewUserAccount object on database.
    *
    * @param IamViewUserAccountCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(IamViewUserAccountCreateRequest $request) {
        $model = IamViewUserAccountService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamViewUserAccount object on database.
    *
    * @param $iamViewUserAccountId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($iamViewUserAccountId, IamViewUserAccountUpdateRequest $request) {
        $model = IamViewUserAccountService::update($iamViewUserAccountId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamViewUserAccount object on database.
    *
    * @param $iamViewUserAccountId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($iamViewUserAccountId) {
        $model = IamViewUserAccountService::delete($iamViewUserAccountId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}