<?php

namespace NextDeveloper\IAM\Http\Controllers\IamUserRoleOverview;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\IamUserRoleOverview\IamUserRoleOverviewUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamUserRoleOverviewQueryFilter;
use NextDeveloper\IAM\Services\IamUserRoleOverviewService;
use NextDeveloper\IAM\Http\Requests\IamUserRoleOverview\IamUserRoleOverviewCreateRequest;

class IamUserRoleOverviewController extends AbstractController
{
    /**
    * This method returns the list of iamuserroleoverviews.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamUserRoleOverviewQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamUserRoleOverviewQueryFilter $filter, Request $request) {
        $data = IamUserRoleOverviewService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $iamUserRoleOverviewId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = IamUserRoleOverviewService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created IamUserRoleOverview object on database.
    *
    * @param IamUserRoleOverviewCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(IamUserRoleOverviewCreateRequest $request) {
        $model = IamUserRoleOverviewService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamUserRoleOverview object on database.
    *
    * @param $iamUserRoleOverviewId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($iamUserRoleOverviewId, IamUserRoleOverviewUpdateRequest $request) {
        $model = IamUserRoleOverviewService::update($iamUserRoleOverviewId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamUserRoleOverview object on database.
    *
    * @param $iamUserRoleOverviewId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($iamUserRoleOverviewId) {
        $model = IamUserRoleOverviewService::delete($iamUserRoleOverviewId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}