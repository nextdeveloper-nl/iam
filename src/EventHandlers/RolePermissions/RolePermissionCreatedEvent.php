<?php

namespace NextDeveloper\IAM\EventHandlers\RolePermissionCreatedEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class RolePermissionCreatedEvent
 *
 * @package PlusClouds\Account\Handlers\Events
 */
class RolePermissionCreatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}