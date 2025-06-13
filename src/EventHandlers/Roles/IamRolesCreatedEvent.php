<?php

namespace NextDeveloper\IAM\EventHandlers\Roles;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class IamRolesCreatedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamRolesCreatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
