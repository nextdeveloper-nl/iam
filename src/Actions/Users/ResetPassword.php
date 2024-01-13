<?php

namespace NextDeveloper\IAM\Actions\Users;

use NextDeveloper\Commons\Actions\AbstractAction;
use NextDeveloper\IAM\Database\Models\Users;

/**
 * This job resets the users password and send a security link with a token in email
 * so that use can come to the web site and/or control panel or authentication service,
 * to reset users password
 */
class ResetPassword extends AbstractAction
{
    /**
     * Sample action;
     * https://.../iam/users/{user-id}/actions/reset-password
     */

    private $action;

    /**
     * This action takes a user object and assigns an Account Manager
     *
     * @param Users $users
     */
    public function __construct(Users $users)
    {
        $this->model = $users;

        parent::__construct();
        $this->action = $this->getAction();
    }

    public function handle()
    {
        $this->setAction($this->action);

        $this->setProgress(0, 'Starting the process');

        $this->setProgress(10, 'Finding the users password mechanism');

        $this->setProgress(25, 'Creating the one time use hash to create password');

        $this->setProgress(50, 'Sending the hash as email');

        $this->setProgress(75, 'Setting the password to null and setting as updateRequired');

        $this->setFinished();
    }
}
