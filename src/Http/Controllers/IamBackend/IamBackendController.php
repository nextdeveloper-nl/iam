<?php

namespace NextDeveloper\IAM\Http\Controllers\IamBackend;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\IamBackend\IamBackendUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamBackendQueryFilter;
use NextDeveloper\IAM\Services\IamBackendService;
use NextDeveloper\IAM\Http\Requests\IamBackend\IamBackendCreateRequest;

class IamBackendController extends AbstractController
{
    /**
    * This method returns the list of iambackends.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamBackendQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamBackendQueryFilter $filter, Request $request) {
        $data = IamBackendService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $iamBackendId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = IamBackendService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created IamBackend object on database.
    *
    * @param IamBackendCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(IamBackendCreateRequest $request) {
        $model = IamBackendService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamBackend object on database.
    *
    * @param $iamBackendId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($iamBackendId, IamBackendUpdateRequest $request) {
        $model = IamBackendService::update($iamBackendId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamBackend object on database.
    *
    * @param $iamBackendId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($iamBackendId) {
        $model = IamBackendService::delete($iamBackendId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}