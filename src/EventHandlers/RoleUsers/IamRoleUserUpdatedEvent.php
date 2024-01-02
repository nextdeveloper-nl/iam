<?php

namespace NextDeveloper\IAM\EventHandlers\RoleUsers;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class IamRoleUserUpdatedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamRoleUserUpdatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}