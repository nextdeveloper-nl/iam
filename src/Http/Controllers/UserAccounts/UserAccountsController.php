<?php

namespace NextDeveloper\IAM\Http\Controllers\UserAccounts;

use Illuminate\Http\Request;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\Commons\Http\Response\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\UserAccounts\UserAccountsUpdateRequest;
use NextDeveloper\IAM\Database\Filters\UserAccountsQueryFilter;
use NextDeveloper\IAM\Database\Models\UserAccounts;
use NextDeveloper\IAM\Services\UserAccountsService;
use NextDeveloper\IAM\Http\Requests\UserAccounts\UserAccountsCreateRequest;
use NextDeveloper\Commons\Http\Traits\Tags;use NextDeveloper\Commons\Http\Traits\Addresses;
class UserAccountsController extends AbstractController
{
    private $model = UserAccounts::class;

    use Tags;
    use Addresses;
    /**
     * This method returns the list of useraccounts.
     *
     * optional http params:
     * - paginate: If you set paginate parameter, the result will be returned paginated.
     *
     * @param  UserAccountsQueryFilter $filter  An object that builds search query
     * @param  Request                 $request Laravel request object, this holds all data about request. Automatically populated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserAccountsQueryFilter $filter, Request $request)
    {
        $data = UserAccountsService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
     * This function returns the list of actions that can be performed on this object.
     *
     * @return void
     */
    public function getActions()
    {
        $data = UserAccountsService::getActions();

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
     * Makes the related action to the object
     *
     * @param  $objectId
     * @param  $action
     * @return array
     */
    public function doAction($objectId, $action)
    {
        $actionId = UserAccountsService::doAction($objectId, $action);

        return $this->withArray(
            [
            'action_id' =>  $actionId
            ]
        );
    }

    /**
     * This method receives ID for the related model and returns the item to the client.
     *
     * @param  $userAccountsId
     * @return mixed|null
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function show($ref)
    {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = UserAccountsService::getByRef($ref);

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method returns the list of sub objects the related object. Sub object means an object which is preowned by
     * this object.
     *
     * It can be tags, addresses, states etc.
     *
     * @param  $ref
     * @param  $subObject
     * @return void
     */
    public function relatedObjects($ref, $subObject)
    {
        $objects = UserAccountsService::relatedObjects($ref, $subObject);

        return ResponsableFactory::makeResponse($this, $objects);
    }

    /**
     * This method created UserAccounts object on database.
     *
     * @param  UserAccountsCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function store(UserAccountsCreateRequest $request)
    {
        if($request->has('validateOnly') && $request->get('validateOnly') == true) {
            return [
                'validation'    =>  'success'
            ];
        }

        $model = UserAccountsService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates UserAccounts object on database.
     *
     * @param  $userAccountsId
     * @param  UserAccountsUpdateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function update($userAccountsId, UserAccountsUpdateRequest $request)
    {
        if($request->has('validateOnly') && $request->get('validateOnly') == true) {
            return [
                'validation'    =>  'success'
            ];
        }

        $model = UserAccountsService::update($userAccountsId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates UserAccounts object on database.
     *
     * @param  $userAccountsId
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function destroy($userAccountsId)
    {
        $model = UserAccountsService::delete($userAccountsId);

        return $this->noContent();
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
