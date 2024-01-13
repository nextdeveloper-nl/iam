<?php

namespace NextDeveloper\IAM\Http\Controllers\LoginMechanisms;

use Illuminate\Http\Request;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\Commons\Http\Response\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\LoginMechanisms\LoginMechanismsUpdateRequest;
use NextDeveloper\IAM\Database\Filters\LoginMechanismsQueryFilter;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Services\LoginMechanismsService;
use NextDeveloper\IAM\Http\Requests\LoginMechanisms\LoginMechanismsCreateRequest;
use NextDeveloper\Commons\Http\Traits\Tags;
class LoginMechanismsController extends AbstractController
{
    private $model = LoginMechanisms::class;

    use Tags;
    /**
     * This method returns the list of loginmechanisms.
     *
     * optional http params:
     * - paginate: If you set paginate parameter, the result will be returned paginated.
     *
     * @param  LoginMechanismsQueryFilter $filter  An object that builds search query
     * @param  Request                    $request Laravel request object, this holds all data about request. Automatically populated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(LoginMechanismsQueryFilter $filter, Request $request)
    {
        $data = LoginMechanismsService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
     * This method receives ID for the related model and returns the item to the client.
     *
     * @param  $loginMechanismsId
     * @return mixed|null
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function show($ref)
    {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = LoginMechanismsService::getByRef($ref);

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
        $objects = LoginMechanismsService::relatedObjects($ref, $subObject);

        return ResponsableFactory::makeResponse($this, $objects);
    }

    /**
     * This method created LoginMechanisms object on database.
     *
     * @param  LoginMechanismsCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function store(LoginMechanismsCreateRequest $request)
    {
        $model = LoginMechanismsService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates LoginMechanisms object on database.
     *
     * @param  $loginMechanismsId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function update($loginMechanismsId, LoginMechanismsUpdateRequest $request)
    {
        $model = LoginMechanismsService::update($loginMechanismsId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates LoginMechanisms object on database.
     *
     * @param  $loginMechanismsId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function destroy($loginMechanismsId)
    {
        $model = LoginMechanismsService::delete($loginMechanismsId);

        return $this->noContent();
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
