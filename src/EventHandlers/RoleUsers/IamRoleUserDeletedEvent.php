<?php

namespace NextDeveloper\IAM\EventHandlers\RoleUsers;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class IamRoleUserDeletedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamRoleUserDeletedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
