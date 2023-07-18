<?php

namespace NextDeveloper\IAM\Http\Controllers\IamLoginMechanism;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\IamLoginMechanism\IamLoginMechanismUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamLoginMechanismQueryFilter;
use NextDeveloper\IAM\Services\IamLoginMechanismService;
use NextDeveloper\IAM\Http\Requests\IamLoginMechanism\IamLoginMechanismCreateRequest;

class IamLoginMechanismController extends AbstractController
{
    /**
    * This method returns the list of iamloginmechanisms.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamLoginMechanismQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamLoginMechanismQueryFilter $filter, Request $request) {
        $data = IamLoginMechanismService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $iamLoginMechanismId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = IamLoginMechanismService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created IamLoginMechanism object on database.
    *
    * @param IamLoginMechanismCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(IamLoginMechanismCreateRequest $request) {
        $model = IamLoginMechanismService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamLoginMechanism object on database.
    *
    * @param $iamLoginMechanismId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($iamLoginMechanismId, IamLoginMechanismUpdateRequest $request) {
        $model = IamLoginMechanismService::update($iamLoginMechanismId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamLoginMechanism object on database.
    *
    * @param $iamLoginMechanismId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($iamLoginMechanismId) {
        $model = IamLoginMechanismService::delete($iamLoginMechanismId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}