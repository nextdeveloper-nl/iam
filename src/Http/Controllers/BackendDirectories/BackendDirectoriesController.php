<?php

namespace NextDeveloper\IAM\Http\Controllers\BackendDirectories;

use Illuminate\Http\Request;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\BackendDirectories\BackendDirectoriesUpdateRequest;
use NextDeveloper\IAM\Database\Filters\BackendDirectoriesQueryFilter;
use NextDeveloper\IAM\Database\Models\BackendDirectories;
use NextDeveloper\IAM\Services\BackendDirectoriesService;
use NextDeveloper\IAM\Http\Requests\BackendDirectories\BackendDirectoriesCreateRequest;
use NextDeveloper\Commons\Http\Traits\Tags;use NextDeveloper\Commons\Http\Traits\Addresses;
class BackendDirectoriesController extends AbstractController
{
    private $model = BackendDirectories::class;

    use Tags;
    use Addresses;
    /**
     * This method returns the list of backenddirectories.
     *
     * optional http params:
     * - paginate: If you set paginate parameter, the result will be returned paginated.
     *
     * @param  BackendDirectoriesQueryFilter $filter  An object that builds search query
     * @param  Request                       $request Laravel request object, this holds all data about request. Automatically populated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(BackendDirectoriesQueryFilter $filter, Request $request)
    {
        $data = BackendDirectoriesService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
     * This method receives ID for the related model and returns the item to the client.
     *
     * @param  $backendDirectoriesId
     * @return mixed|null
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function show($ref)
    {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = BackendDirectoriesService::getByRef($ref);

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
        $objects = BackendDirectoriesService::relatedObjects($ref, $subObject);

        return ResponsableFactory::makeResponse($this, $objects);
    }

    /**
     * This method created BackendDirectories object on database.
     *
     * @param  BackendDirectoriesCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function store(BackendDirectoriesCreateRequest $request)
    {
        $model = BackendDirectoriesService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates BackendDirectories object on database.
     *
     * @param  $backendDirectoriesId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function update($backendDirectoriesId, BackendDirectoriesUpdateRequest $request)
    {
        $model = BackendDirectoriesService::update($backendDirectoriesId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates BackendDirectories object on database.
     *
     * @param  $backendDirectoriesId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function destroy($backendDirectoriesId)
    {
        $model = BackendDirectoriesService::delete($backendDirectoriesId);

        return $this->noContent();
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
