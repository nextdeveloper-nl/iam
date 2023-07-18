<?php

namespace NextDeveloper\IAM\Http\Controllers\IamLoginLog;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\IamLoginLog\IamLoginLogUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamLoginLogQueryFilter;
use NextDeveloper\IAM\Services\IamLoginLogService;
use NextDeveloper\IAM\Http\Requests\IamLoginLog\IamLoginLogCreateRequest;

class IamLoginLogController extends AbstractController
{
    /**
    * This method returns the list of iamloginlogs.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamLoginLogQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamLoginLogQueryFilter $filter, Request $request) {
        $data = IamLoginLogService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $iamLoginLogId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = IamLoginLogService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created IamLoginLog object on database.
    *
    * @param IamLoginLogCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(IamLoginLogCreateRequest $request) {
        $model = IamLoginLogService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamLoginLog object on database.
    *
    * @param $iamLoginLogId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($iamLoginLogId, IamLoginLogUpdateRequest $request) {
        $model = IamLoginLogService::update($iamLoginLogId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamLoginLog object on database.
    *
    * @param $iamLoginLogId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($iamLoginLogId) {
        $model = IamLoginLogService::delete($iamLoginLogId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}