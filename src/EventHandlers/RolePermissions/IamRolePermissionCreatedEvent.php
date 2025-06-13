<?php

namespace NextDeveloper\IAM\EventHandlers\RolePermissions;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class IamRolePermissionCreatedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamRolePermissionCreatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
