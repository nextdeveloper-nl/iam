<?php

namespace NextDeveloper\IAM\Http\Controllers\AccountUserPerspective;

use Illuminate\Http\Request;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\Commons\Http\Response\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\AccountUserPerspective\AccountUserPerspectiveUpdateRequest;
use NextDeveloper\IAM\Database\Filters\AccountUserPerspectiveQueryFilter;
use NextDeveloper\IAM\Database\Models\AccountUserPerspective;
use NextDeveloper\IAM\Services\AccountUserPerspectiveService;
use NextDeveloper\IAM\Http\Requests\AccountUserPerspective\AccountUserPerspectiveCreateRequest;
use NextDeveloper\Commons\Http\Traits\Tags;use NextDeveloper\Commons\Http\Traits\Addresses;
class AccountUserPerspectiveController extends AbstractController
{
    private $model = AccountUserPerspective::class;

    use Tags;
    use Addresses;
    /**
     * This method returns the list of accountuserperspectives.
     *
     * optional http params:
     * - paginate: If you set paginate parameter, the result will be returned paginated.
     *
     * @param  AccountUserPerspectiveQueryFilter $filter  An object that builds search query
     * @param  Request                           $request Laravel request object, this holds all data about request. Automatically populated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(AccountUserPerspectiveQueryFilter $filter, Request $request)
    {
        $data = AccountUserPerspectiveService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
     * This method receives ID for the related model and returns the item to the client.
     *
     * @param  $accountUserPerspectiveId
     * @return mixed|null
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function show($ref)
    {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = AccountUserPerspectiveService::getByRef($ref);

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
        $objects = AccountUserPerspectiveService::relatedObjects($ref, $subObject);

        return ResponsableFactory::makeResponse($this, $objects);
    }

    /**
     * This method created AccountUserPerspective object on database.
     *
     * @param  AccountUserPerspectiveCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function store(AccountUserPerspectiveCreateRequest $request)
    {
        $model = AccountUserPerspectiveService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates AccountUserPerspective object on database.
     *
     * @param  $accountUserPerspectiveId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function update($accountUserPerspectiveId, AccountUserPerspectiveUpdateRequest $request)
    {
        $model = AccountUserPerspectiveService::update($accountUserPerspectiveId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates AccountUserPerspective object on database.
     *
     * @param  $accountUserPerspectiveId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function destroy($accountUserPerspectiveId)
    {
        $model = AccountUserPerspectiveService::delete($accountUserPerspectiveId);

        return $this->noContent();
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
