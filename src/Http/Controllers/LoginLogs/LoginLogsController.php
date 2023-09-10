<?php

namespace NextDeveloper\IAM\Http\Controllers\LoginLogs;

use Illuminate\Http\Request;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\LoginLogs\LoginLogsUpdateRequest;
use NextDeveloper\IAM\Database\Filters\LoginLogsQueryFilter;
use NextDeveloper\IAM\Services\LoginLogsService;
use NextDeveloper\IAM\Http\Requests\LoginLogs\LoginLogsCreateRequest;

class LoginLogsController extends AbstractController
{
    /**
    * This method returns the list of loginlogs.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param LoginLogsQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(LoginLogsQueryFilter $filter, Request $request) {
        $data = LoginLogsService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $loginLogsId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = LoginLogsService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created LoginLogs object on database.
    *
    * @param LoginLogsCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(LoginLogsCreateRequest $request) {
        $model = LoginLogsService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates LoginLogs object on database.
    *
    * @param $loginLogsId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($loginLogsId, LoginLogsUpdateRequest $request) {
        $model = LoginLogsService::update($loginLogsId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates LoginLogs object on database.
    *
    * @param $loginLogsId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($loginLogsId) {
        $model = LoginLogsService::delete($loginLogsId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}