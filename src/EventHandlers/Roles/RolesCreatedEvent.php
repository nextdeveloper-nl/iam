<?php

namespace NextDeveloper\IAM\EventHandlers\RolesCreatedEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class RolesCreatedEvent
 *
 * @package PlusClouds\Account\Handlers\Events
 */
class RolesCreatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
