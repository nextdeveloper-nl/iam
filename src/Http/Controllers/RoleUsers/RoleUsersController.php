<?php

namespace NextDeveloper\IAM\Http\Controllers\RoleUsers;

use Illuminate\Http\Request;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\Commons\Http\Response\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\RoleUsers\RoleUsersUpdateRequest;
use NextDeveloper\IAM\Database\Filters\RoleUsersQueryFilter;
use NextDeveloper\IAM\Database\Models\RoleUsers;
use NextDeveloper\IAM\Services\RoleUsersService;
use NextDeveloper\IAM\Http\Requests\RoleUsers\RoleUsersCreateRequest;
use NextDeveloper\Commons\Http\Traits\Tags;
class RoleUsersController extends AbstractController
{
    private $model = RoleUsers::class;

    use Tags;
    /**
     * This method returns the list of roleusers.
     *
     * optional http params:
     * - paginate: If you set paginate parameter, the result will be returned paginated.
     *
     * @param  RoleUsersQueryFilter $filter  An object that builds search query
     * @param  Request              $request Laravel request object, this holds all data about request. Automatically populated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(RoleUsersQueryFilter $filter, Request $request)
    {
        $data = RoleUsersService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
     * This method receives ID for the related model and returns the item to the client.
     *
     * @param  $roleUsersId
     * @return mixed|null
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function show($ref)
    {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = RoleUsersService::getByRef($ref);

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
        $objects = RoleUsersService::relatedObjects($ref, $subObject);

        return ResponsableFactory::makeResponse($this, $objects);
    }

    /**
     * This method created RoleUsers object on database.
     *
     * @param  RoleUsersCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function store(RoleUsersCreateRequest $request)
    {
        $model = RoleUsersService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates RoleUsers object on database.
     *
     * @param  $roleUsersId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function update($roleUsersId, RoleUsersUpdateRequest $request)
    {
        $model = RoleUsersService::update($roleUsersId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates RoleUsers object on database.
     *
     * @param  $roleUsersId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function destroy($roleUsersId)
    {
        $model = RoleUsersService::delete($roleUsersId);

        return $this->noContent();
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}