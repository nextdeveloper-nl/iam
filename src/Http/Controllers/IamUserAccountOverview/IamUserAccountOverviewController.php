<?php

namespace NextDeveloper\IAM\Http\Controllers\IamUserAccountOverview;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\IamUserAccountOverview\IamUserAccountOverviewUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamUserAccountOverviewQueryFilter;
use NextDeveloper\IAM\Services\IamUserAccountOverviewService;
use NextDeveloper\IAM\Http\Requests\IamUserAccountOverview\IamUserAccountOverviewCreateRequest;

class IamUserAccountOverviewController extends AbstractController
{
    /**
    * This method returns the list of iamuseraccountoverviews.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamUserAccountOverviewQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamUserAccountOverviewQueryFilter $filter, Request $request) {
        $data = IamUserAccountOverviewService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $iamUserAccountOverviewId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = IamUserAccountOverviewService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created IamUserAccountOverview object on database.
    *
    * @param IamUserAccountOverviewCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(IamUserAccountOverviewCreateRequest $request) {
        $model = IamUserAccountOverviewService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamUserAccountOverview object on database.
    *
    * @param $iamUserAccountOverviewId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($iamUserAccountOverviewId, IamUserAccountOverviewUpdateRequest $request) {
        $model = IamUserAccountOverviewService::update($iamUserAccountOverviewId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamUserAccountOverview object on database.
    *
    * @param $iamUserAccountOverviewId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($iamUserAccountOverviewId) {
        $model = IamUserAccountOverviewService::delete($iamUserAccountOverviewId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}