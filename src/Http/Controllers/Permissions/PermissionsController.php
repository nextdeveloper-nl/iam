<?php

namespace NextDeveloper\IAM\Http\Controllers\Permissions;

use Illuminate\Http\Request;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\Permissions\PermissionsUpdateRequest;
use NextDeveloper\IAM\Database\Filters\PermissionsQueryFilter;
use NextDeveloper\IAM\Database\Models\Permissions;
use NextDeveloper\IAM\Services\PermissionsService;
use NextDeveloper\IAM\Http\Requests\Permissions\PermissionsCreateRequest;
use NextDeveloper\Commons\Http\Traits\Tags;
class PermissionsController extends AbstractController
{
    private $model = Permissions::class;

    use Tags;
    /**
     * This method returns the list of permissions.
     *
     * optional http params:
     * - paginate: If you set paginate parameter, the result will be returned paginated.
     *
     * @param  PermissionsQueryFilter $filter  An object that builds search query
     * @param  Request                $request Laravel request object, this holds all data about request. Automatically populated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PermissionsQueryFilter $filter, Request $request)
    {
        $data = PermissionsService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
     * This method receives ID for the related model and returns the item to the client.
     *
     * @param  $permissionsId
     * @return mixed|null
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function show($ref)
    {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = PermissionsService::getByRef($ref);

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
        $objects = PermissionsService::relatedObjects($ref, $subObject);

        return ResponsableFactory::makeResponse($this, $objects);
    }

    /**
     * This method created Permissions object on database.
     *
     * @param  PermissionsCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function store(PermissionsCreateRequest $request)
    {
        $model = PermissionsService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates Permissions object on database.
     *
     * @param  $permissionsId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function update($permissionsId, PermissionsUpdateRequest $request)
    {
        $model = PermissionsService::update($permissionsId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates Permissions object on database.
     *
     * @param  $permissionsId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function destroy($permissionsId)
    {
        $model = PermissionsService::delete($permissionsId);

        return $this->noContent();
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
