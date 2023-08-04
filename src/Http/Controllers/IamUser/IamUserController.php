<?php

namespace NextDeveloper\IAM\Http\Controllers\IamUser;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Http\Requests\IamUser\IamUserUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamUserQueryFilter;
use NextDeveloper\IAM\Services\IamUserService;
use NextDeveloper\IAM\Http\Requests\IamUser\IamUserCreateRequest;

class IamUserController extends AbstractController
{
    /**
    * This method returns the list of iamusers.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamUserQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamUserQueryFilter $filter, Request $request) {
        $data = IamUserService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method receives ID for the related model and returns the item to the client.
    *
    * @param $iamUserId
    * @return mixed|null
    * @throws \Laravel\Octane\Exceptions\DdException
    */
    public function show($ref) {
        if($ref == 'me')
            return $this->me();
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = IamUserService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method created IamUser object on database.
    *
    * @param IamUserCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function store(IamUserCreateRequest $request) {
        $model = IamUserService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamUser object on database.
    *
    * @param $iamUserId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update($iamUserId, IamUserUpdateRequest $request) {
        $model = IamUserService::update($iamUserId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
    * This method updates IamUser object on database.
    *
    * @param $iamUserId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function destroy($iamUserId) {
        $model = IamUserService::delete($iamUserId);

        return ResponsableFactory::makeResponse($this, $model);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    /**
     * This method returns the logged in user information
     *
     * @param $iamUserId
     * @return mixed|null
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function me() {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = UserHelper::me();

        return ResponsableFactory::makeResponse($this, $model);
    }

}