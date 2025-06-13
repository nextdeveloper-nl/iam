<?php

namespace NextDeveloper\IAM\EventHandlers\RoleUserCreatedEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class RoleUserCreatedEvent
 *
 * @package PlusClouds\Account\Handlers\Events
 */
class RoleUserCreatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
