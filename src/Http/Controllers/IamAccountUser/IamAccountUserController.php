<?php

namespace NextDeveloper\IAM\Http\Controllers\IamAccountUser;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\IamAccountUser\IamAccountUserUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamAccountUserQueryFilter;
use NextDeveloper\IAM\Services\IamAccountUserService;
use NextDeveloper\IAM\Http\Requests\IamAccountUser\IamAccountUserCreateRequest;

class IamAccountUserController extends AbstractController
{
    /**
    * This method returns the list of iamaccountusers.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamAccountUserQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamAccountUserQueryFilter $filter, Request $request) {
        $data = IamAccountUserService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $iamAccountUserId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = IamAccountUserService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created IamAccountUser object on database.
    *
    * @param IamAccountUserCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(IamAccountUserCreateRequest $request) {
        $model = IamAccountUserService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamAccountUser object on database.
    *
    * @param $iamAccountUserId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($iamAccountUserId, IamAccountUserUpdateRequest $request) {
        $model = IamAccountUserService::update($iamAccountUserId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamAccountUser object on database.
    *
    * @param $iamAccountUserId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($iamAccountUserId) {
        $model = IamAccountUserService::delete($iamAccountUserId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}