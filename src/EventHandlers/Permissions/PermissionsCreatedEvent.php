<?php

namespace NextDeveloper\IAM\EventHandlers\PermissionsCreatedEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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