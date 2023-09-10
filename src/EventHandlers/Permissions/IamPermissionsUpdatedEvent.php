<?php

namespace NextDeveloper\IAM\EventHandlers\Permissions;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class IamPermissionsUpdatedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamPermissionsUpdatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}