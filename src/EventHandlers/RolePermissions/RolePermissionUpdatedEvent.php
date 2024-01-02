<?php

namespace NextDeveloper\IAM\EventHandlers\RolePermissionUpdatedEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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