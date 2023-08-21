<?php

namespace NextDeveloper\IAM\Http\Controllers\IamRole;

use Illuminate\Http\Request;
use Laravel\Passport\Bridge\User;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Database\Models\IamUserRoleOverview;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Http\Requests\IamRole\IamRoleUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamRoleQueryFilter;
use NextDeveloper\IAM\Services\IamRoleService;
use NextDeveloper\IAM\Http\Requests\IamRole\IamRoleCreateRequest;

class IamMyRoleController extends AbstractController
{
    /**
    * This method returns the list of iamroles.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamRoleQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamRoleQueryFilter $filter, Request $request) {
        $data = IamUserRoleOverview::where('iam_user_id', UserHelper::me()->id)->get();

        return ResponsableFactory::makeResponse($this, $data);
    }

    /**
    * This method sets the current role for the related user for current account
    *
    * @param $iamRoleId
    * @param CountryCreateRequest $request
    * @return mixed|null
    * @throws \NextDeveloper\Commons\Exceptions\CannotCreateModelException
    */
    public function update(IamRoleUpdateRequest $request) {
        $iamRoleId = $request->get('iam_role_id');

        if($iamRoleId == null)
            return $this->errorUnprocessable('Cannot get the role ID. Please provide role_id parameter
with x-www-form-urlencoded type of request.');

        $data = UserHelper::switchToRoleByRoleId(UserHelper::me(), $iamRoleId);

        return ResponsableFactory::makeResponse($this, $data);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}