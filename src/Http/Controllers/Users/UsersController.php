<?php

namespace NextDeveloper\IAM\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Http\Requests\Users\UsersUpdateRequest;
use NextDeveloper\IAM\Database\Filters\UsersQueryFilter;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Services\UsersService;
use NextDeveloper\IAM\Http\Requests\Users\UsersCreateRequest;
use NextDeveloper\Commons\Http\Traits\Tags;
class UsersController extends AbstractController
{
    private $model = Users::class;

    use Tags;
    /**
     * This method returns the list of users.
     *
     * optional http params:
     * - paginate: If you set paginate parameter, the result will be returned paginated.
     *
     * @param  UsersQueryFilter $filter  An object that builds search query
     * @param  Request          $request Laravel request object, this holds all data about request. Automatically populated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UsersQueryFilter $filter, Request $request)
    {
        $data = UsersService::get($filter, $request->all());

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
     * This method receives ID for the related model and returns the item to the client.
     *
     * @param  $usersId
     * @return mixed|null
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function show($ref)
    {
        //  Here we are not using Laravel Route Model Binding. Please check routeBinding.md file
        //  in NextDeveloper Platform Project
        $model = UsersService::getByRef($ref);

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
        $objects = UsersService::relatedObjects($ref, $subObject);

        return ResponsableFactory::makeResponse($this, $objects);
    }

    /**
     * This function triggers related actions for the related object
     *
     * @param $ref
     * @param $action
     * @return void
     */
    public function actions($ref, $action)
    {
        $obj = Users::where('uuid', $ref)->first();

        if(!$obj)
            return $this->errorNotFound('Cannot find the related object you are looking for.'
                . 'That is why I cannot also run this action.');

        //  reset-password  =>  ResetPassword
        $action = Str::ucfirst(Str::camel($action));

        if(class_exists('\NextDeveloper\IAM\Actions\Users\\' . $action)) {
            $action = '\NextDeveloper\IAM\Actions\Users\\' . $action;
            dispatch( new $action($obj) );

            return $this->withArray([
                'status'    =>  'action sent'
            ]);
        } else {
            return $this->withError('Cannot find the related action for this object. '
                . ' Please provide me a valid action');
        }
    }

    /**
     * This method created Users object on database.
     *
     * @param  UsersCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function store(UsersCreateRequest $request)
    {
        $model = UsersService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates Users object on database.
     *
     * @param  $usersId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function update($usersId, UsersUpdateRequest $request)
    {
        $model = UsersService::update($usersId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates Users object on database.
     *
     * @param  $usersId
     * @param  CountryCreateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function destroy($usersId)
    {
        $model = UsersService::delete($usersId);

        return $this->noContent();
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
