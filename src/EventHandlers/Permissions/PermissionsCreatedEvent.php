<?php

namespace NextDeveloper\IAM\EventHandlers\PermissionsCreatedEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class PermissionsCreatedEvent
 *
 * @package PlusClouds\Account\Handlers\Events
 */
class PermissionsCreatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
