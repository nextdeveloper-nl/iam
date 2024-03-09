<?php

namespace NextDeveloper\IAM\Actions\Users;

use NextDeveloper\Commons\Actions\AbstractAction;
use NextDeveloper\IAM\Database\Models\Users;

class RegisterUser extends AbstractAction
{
    private $action;

    private $user;

    public function __construct(Users $users)
    {
        $this->user = $users;

        parent::__construct();
        $this->action = $this->getAction();
    }

    public function handle()
    {
        $this->setProgress(0, 'Registering the user');

        $this->setFinished();
    }
}
