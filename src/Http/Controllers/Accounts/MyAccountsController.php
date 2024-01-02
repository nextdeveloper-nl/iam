<?php

namespace NextDeveloper\IAM\Http\Controllers\Accounts;

use Illuminate\Http\Request;
use NextDeveloper\Generator\Common\AbstractController;
use NextDeveloper\Generator\Http\Traits\ResponsableFactory;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Database\Filters\AccountsQueryFilter;

class MyAccountsController extends AbstractController
{
    /**
     * This method returns the list of Accountss.
     *
     * optional http params:
     * - paginate: If you set paginate parameter, the result will be returned paginated.
     *
     * @param AccountsQueryFilter $filter An object that builds search query
     * @param Request $request Laravel request object, this holds all data about request. Automatically populated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(AccountsQueryFilter $filter, Request $request) {
        return ResponsableFactory::makeResponse($this, UserHelper::allAccounts());
    }

    public function update(Request $request) {
        $AccountsId = $request->get('id');

        if($AccountsId == null)
            return $this->errorUnprocessable('Cannot get the account ID. Please provide id parameter
with x-www-form-urlencoded type of request.');

        $account = UserHelper::switchAccountTo(Accounts::findByUuid($AccountsId), UserHelper::me());

        return ResponsableFactory::makeResponse($this, $account);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}