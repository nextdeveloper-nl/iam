<?php

namespace NextDeveloper\IAM\EventHandlers\RolePermissionUpdatedEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class RolePermissionUpdatedEvent
 *
 * @package PlusClouds\Account\Handlers\Events
 */
class RolePermissionUpdatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
