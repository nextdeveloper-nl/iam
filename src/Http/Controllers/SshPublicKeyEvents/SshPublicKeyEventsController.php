<?php

namespace NextDeveloper\IAM\Http\Controllers\SshPublicKeyEvents;

use Illuminate\Http\Request;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\Commons\Http\Response\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\SshPublicKeyEvents\SshPublicKeyEventsUpdateRequest;
use NextDeveloper\IAM\Database\Filters\SshPublicKeyEventsQueryFilter;
use NextDeveloper\IAM\Database\Models\SshPublicKeyEvents;
use NextDeveloper\IAM\Services\SshPublicKeyEventsService;
use NextDeveloper\IAM\Http\Requests\SshPublicKeyEvents\SshPublicKeyEventsCreateRequest;
use NextDeveloper\Commons\Http\Traits\Tags as TagsTrait;use NextDeveloper\Commons\Http\Traits\Addresses as AddressesTrait;
class SshPublicKeyEventsController extends AbstractController
{
    private $model = SshPublicKeyEvents::class;

    use TagsTrait;
    use AddressesTrait;
    /**
     * This method returns the list of sshpublickeyevents.
     *
     * optional http params:
     * - paginate: If you set paginate parameter, the result will be returned paginated.
     *
     * @param  SshPublicKeyEventsQueryFilter $filter  An object that builds search query
     * @param  Request                       $request Laravel request object, this holds all data about request. Automatically populated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SshPublicKeyEventsQueryFilter $filter, Request $request)
    {
        $data = SshPublicKeyEventsService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
     * This function returns the list of actions that can be performed on this object.
     *
     * @return void
     */
    public function getActions()
    {
        $data = SshPublicKeyEventsService::getActions();

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
        $actionId = SshPublicKeyEventsService::doAction($objectId, $action, request()->all());

        return $this->withArray(
            [
            'action_id' =>  $actionId
            ]
        );
    }

    /**
     * This method receives ID for the related model and returns the item to the client.
     *
     * @param  $sshPublicKeyEventsId
     * @return mixed|null
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function show($ref)
    {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = SshPublicKeyEventsService::getByRef($ref);

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
        $objects = SshPublicKeyEventsService::relatedObjects($ref, $subObject);

        return ResponsableFactory::makeResponse($this, $objects);
    }

    /**
     * This method created SshPublicKeyEvents object on database.
     *
     * @param  SshPublicKeyEventsCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function store(SshPublicKeyEventsCreateRequest $request)
    {
        if($request->has('validateOnly') && $request->get('validateOnly') == true) {
            return [
                'validation'    =>  'success'
            ];
        }

        $model = SshPublicKeyEventsService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates SshPublicKeyEvents object on database.
     *
     * @param  $sshPublicKeyEventsId
     * @param  SshPublicKeyEventsUpdateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function update($sshPublicKeyEventsId, SshPublicKeyEventsUpdateRequest $request)
    {
        if($request->has('validateOnly') && $request->get('validateOnly') == true) {
            return [
                'validation'    =>  'success'
            ];
        }

        $model = SshPublicKeyEventsService::update($sshPublicKeyEventsId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates SshPublicKeyEvents object on database.
     *
     * @param  $sshPublicKeyEventsId
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function destroy($sshPublicKeyEventsId)
    {
        $model = SshPublicKeyEventsService::delete($sshPublicKeyEventsId);

        return $this->noContent();
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
