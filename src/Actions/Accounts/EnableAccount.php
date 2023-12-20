<?php

namespace NextDeveloper\IAM\Actions\Accounts;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NextDeveloper\Commons\Actions\AbstractAction;
use NextDeveloper\CRM\Database\Models\Users;

/**
 * This job resets the users password and send a security link with a token in email
 * so that use can come to the web site and/or control panel or authentication service,
 * to reset users password
 */
class EnableAccount extends AbstractAction
{
    /**
     * Sample action;
     * https://.../iam/users/{user-id}/action/reset-password
     */

    /**
     * This action takes a user object and assigns an Account Manager
     *
     * @param Users $users
     */
    public function __construct(Users $users)
    {
        parent::__construct();
    }

    public function handle()
    {
        /**
         * 1) Get account
         * 2) Check if account is valid for enabling
         * 3) Enable account
         * 4) Send user email notification about enabling account
         */

        $this->setProgress(0, 'Starting to get account for enabling');

        $this->setProgress(10, "Got the account for enabling moving to account checks");

        $this->setProgress(50, "Account is eligible for enabling, enabilng account");

        $this->setProgress(90, "Account enabled");

        $this->setProgress(100, "Process finished");
    }
}
