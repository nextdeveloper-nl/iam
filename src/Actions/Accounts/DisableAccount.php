<?php

namespace NextDeveloper\IAM\Actions\Accounts;

use NextDeveloper\Commons\Actions\AbstractAction;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Services\AccountsService;

/**
 * This job resets the users password and send a security link with a token in email
 * so that use can come to the web site and/or control panel or authentication service,
 * to reset users password
 */
class DisableAccount extends AbstractAction
{
    /**
     * Sample action;
     * https://.../iam/users/{user-id}/action/reset-password
     */

    /**
     * This action takes a user object and assigns an Account Manager
     *
     * @param Accounts $accounts
     */
    public function __construct(private Accounts $accounts)
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->setProgress(0, 'Starting to disable account');

        $this->accounts = AccountsService::disable($this->accounts);

        $this->setProgress(50, 'Account has been disabled');

        //  Send notification to the account owner
        //  Account owner is; iam_user_id in iam_accounts table



    }
}
