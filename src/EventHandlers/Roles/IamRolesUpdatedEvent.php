<?php

namespace NextDeveloper\IAM\EventHandlers\Roles;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class IamRolesUpdatedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamRolesUpdatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}