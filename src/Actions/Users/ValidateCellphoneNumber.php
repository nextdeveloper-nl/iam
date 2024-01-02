<?php

namespace NextDeveloper\IAM\Actions\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NextDeveloper\Commons\Actions\AbstractAction;
use NextDeveloper\CRM\Database\Models\Users;

class ValidateCellphoneNumber extends AbstractAction
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

    }
}
