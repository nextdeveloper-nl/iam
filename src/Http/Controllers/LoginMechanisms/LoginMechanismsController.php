<?php

namespace NextDeveloper\IAM\Http\Controllers\LoginMechanisms;

use Illuminate\Http\Request;
use NextDeveloper\Commons\Http\Response\ResponsableFactory;
use NextDeveloper\Commons\Http\Traits\Addresses;
use NextDeveloper\Commons\Http\Traits\Tags;
use NextDeveloper\IAM\Database\Filters\LoginMechanismsQueryFilter;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Exceptions\CannotFindUserException;
use NextDeveloper\IAM\Exceptions\UnauthorizedException;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\IAM\Http\Requests\LoginMechanisms\LoginMechanismsCreateRequest;
use NextDeveloper\IAM\Http\Requests\LoginMechanisms\LoginMechanismsUpdateRequest;
use NextDeveloper\IAM\Http\Requests\LoginMechanisms\SetPasswordRequest;
use NextDeveloper\IAM\Services\LoginMechanismsService;

class LoginMechanismsController extends AbstractController
{
    private $model = LoginMechanisms::class;

    use Tags;
    use Addresses;
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
     * This function returns the list of actions that can be performed on this object.
     *
     * @return void
     */
    public function getActions()
    {
        $data = LoginMechanismsService::getActions();

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
        $actionId = LoginMechanismsService::doAction($objectId, $action, request()->all());

        return $this->withArray(
            [
                'action_id' => $actionId
            ]
        );
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
        if ($request->has('validateOnly') && $request->get('validateOnly') == true) {
            return [
                'validation' => 'success'
            ];
        }

        $model = LoginMechanismsService::create($request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates LoginMechanisms object on database.
     *
     * @param  $loginMechanismsId
     * @param  LoginMechanismsUpdateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function update($loginMechanismsId, LoginMechanismsUpdateRequest $request)
    {
        if ($request->has('validateOnly') && $request->get('validateOnly') == true) {
            return [
                'validation' => 'success'
            ];
        }

        $model = LoginMechanismsService::update($loginMechanismsId, $request->validated());

        return ResponsableFactory::makeResponse($this, $model);
    }

    /**
     * This method updates LoginMechanisms object on database.
     *
     * @param  $loginMechanismsId
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function destroy($loginMechanismsId)
    {
        $model = LoginMechanismsService::delete($loginMechanismsId);

        return $this->noContent();
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    /**
     * Set password for the authenticated user
     *
     * This endpoint allows users to set or update their password. When updating,
     * users can optionally provide their current password for verification.
     *
     *
     * @param SetPasswordRequest $request Request containing password and optional current_password
     * @return mixed The updated login mechanism or validation response
     * @throws CannotFindUserException If the user is not authenticated
     * @throws UnauthorizedException If current password verification fails
     *
     * @example
     * POST /api/iam/login-mechanisms/set-password
     * {
     *   "password": "NewSecure123!",
     *   "current_password": "OldPassword123", // optional, recommended for updates
     *   "mechanism_name": "password" // optional, defaults to "password"
     * }
     */
    public function setPassword(SetPasswordRequest $request)
    {
        // Support validation-only mode
        if ($request->has('validateOnly') && $request->get('validateOnly')) {
            return [
                'validation' => 'success'
            ];
        }

        // Get the authenticated user
        $user = \NextDeveloper\IAM\Helpers\UserHelper::me();

        if (!$user) {
            throw new CannotFindUserException('User not authenticated. Please log in to set a password.');
        }

        // Initialize the login mechanisms service
        $loginService = new LoginMechanismsService($user);

        // Get validated data
        $data = $request->validated();
        $mechanismName = $data['mechanism_name'] ?? 'password';

        // Set the password (will throw UnauthorizedException if the current password is wrong)
        $mechanism = $loginService->setPassword($data, $mechanismName);

        return ResponsableFactory::makeResponse($this, $mechanism);
    }

}
