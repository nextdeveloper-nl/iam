<?php

namespace NextDeveloper\IAM\Http\Controllers\IamAccount;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Database\Models\IamAccount;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Http\Requests\IamAccount\IamAccountUpdateRequest;
use NextDeveloper\IAM\Database\Filters\IamAccountQueryFilter;
use NextDeveloper\IAM\Services\IamAccountService;
use NextDeveloper\IAM\Http\Requests\IamAccount\IamAccountCreateRequest;

class IamMyAccountController extends AbstractController
{
    /**
    * This method returns the list of iamaccounts.
    *
    * optional http params:
    * - paginate: If you set paginate parameter, the result will be returned paginated.
    *
    * @param IamAccountQueryFilter $filter An object that builds search query
    * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(IamAccountQueryFilter $filter, Request $request) {
        return ResponsableFactory::makeResponse($this, UserHelper::allAccounts());
    }

    public function update(Request $request) {
        $iamAccountId = $request->get('id');

        if($iamAccountId == null)
            return $this->errorUnprocessable('Cannot get the account ID. Please provide id parameter
with x-www-form-urlencoded type of request.');

        $account = UserHelper::switchAccountTo(IamAccount::findByUuid($iamAccountId), UserHelper::me());

        return ResponsableFactory::makeResponse($this, $account);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}