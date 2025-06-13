<?php

namespace NextDeveloper\IAM\Http\Controllers\AccountUsersPerspective;

use Illuminate\Http\Request;
use NextDeveloper\Commons\Http\Response\ResponsableFactory;
use NextDeveloper\Commons\Http\Traits\Addresses as AddressesTrait;
use NextDeveloper\Commons\Http\Traits\Tags as TagsTrait;
use NextDeveloper\IAM\Database\Filters\AccountUsersPerspectiveQueryFilter;
use NextDeveloper\IAM\Database\Models\AccountUsersPerspective;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\IAM\Http\Requests\AccountUsersPerspective\AccountUsersPerspectiveCreateRequest;
use NextDeveloper\IAM\Http\Requests\AccountUsersPerspective\AccountUsersPerspectiveUpdateRequest;
use NextDeveloper\IAM\Services\AccountUsersPerspectiveService;

class AccountUsersPerspectiveController extends AbstractController
{
    private $model = AccountUsersPerspective::class;

    use TagsTrait;
    use AddressesTrait;
    /**
     * This method returns the list of accountusersperspectives.
     *
     * optional http params:
     * - paginate: If you set paginate parameter, the result will be returned paginated.
     *
     * @param  AccountUsersPerspectiveQueryFilter $filter  An object that builds search query
     * @param  Request                            $request Laravel request object, this holds all data about request. Automatically populated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(AccountUsersPerspectiveQueryFilter $filter, Request $request)
    {
        $data = AccountUsersPerspectiveService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
     * This function returns the list of actions that can be performed on this object.
     *
     * @return void
     */
    public function getActions()
    {
        $data = AccountUsersPerspectiveService::getActions();

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
        $actionId = AccountUsersPerspectiveService::doAction($objectId, $action, request()->all());

        return $this->withArray(
            [
            'action_id' =>  $actionId
            ]
        );
    }

    /**
     * This method receives ID for the related model and returns the item to the client.
     *
     * @param  $accountUsersPerspectiveId
     * @return mixed|null
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function show($ref)
    {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = AccountUsersPerspectiveService::getByRef($ref);

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
        $objects = AccountUsersPerspectiveService::relatedObjects($ref, $subObject);

        return ResponsableFactory::makeResponse($this, $objects);
    }

    /**
     * This method created AccountUsersPerspective object on database.
     *
     * @param  AccountUsersPerspectiveCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function store(AccountUsersPerspectiveCreateRequest $request)
    {
        if($request->has('validateOnly') && $request->get('validateOnly') == true) {
            return [
                'validation'    =>  'success'
            ];
        }

        $model = AccountUsersPerspectiveService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates AccountUsersPerspective object on database.
     *
     * @param  $accountUsersPerspectiveId
     * @param  AccountUsersPerspectiveUpdateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function update($accountUsersPerspectiveId, AccountUsersPerspectiveUpdateRequest $request)
    {
        if($request->has('validateOnly') && $request->get('validateOnly') == true) {
            return [
                'validation'    =>  'success'
            ];
        }

        $model = AccountUsersPerspectiveService::update($accountUsersPerspectiveId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates AccountUsersPerspective object on database.
     *
     * @param  $accountUsersPerspectiveId
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function destroy($accountUsersPerspectiveId)
    {
        $model = AccountUsersPerspectiveService::delete($accountUsersPerspectiveId);

        return $this->noContent();
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
