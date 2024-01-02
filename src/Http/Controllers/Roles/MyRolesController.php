<?php

namespace NextDeveloper\IAM\Http\Controllers\Roles;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Database\Models\UserRoleOverview;
use NextDeveloper\IAM\Database\Models\UserRoles;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Http\Requests\Roles\RolesUpdateRequest;
use NextDeveloper\IAM\Database\Filters\RolesQueryFilter;

class MyRolesController extends AbstractController
{
    /**
     * This method returns the list of Roless.
     *
     * optional http params:
     * - paginate: If you set paginate parameter, the result will be returned paginated.
     *
     * @param RolesQueryFilter $filter An object that builds search query
     * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(RolesQueryFilter $filter, Request $request) {
        $data = UserRoles::where('iam_user_id', UserHelper::me()->id)->get();

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
     * This method sets the current role for the related user for current account
     *
     * @param $RolesId
     * @param RolesUpdateRequest $request
     * @return mixed|null
     * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
     */
    public function update(RolesUpdateRequest $request) {
        $RolesId = $request->get('id');

        if($RolesId == null)
            return $this->errorUnprocessable('Cannot get the role ID. Please provide role_id parameter
with x-www-form-urlencoded type of request.');

        $data = UserHelper::switchToRoleByRoleId(UserHelper::me(), $RolesId);

        return ResponsableFactory::makeResponse($this, $data);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
