<?php

namespace NextDeveloper\IAM\EventHandlers\IamRole;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class IamRoleCreatedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamRoleCreatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}