<?php

namespace NextDeveloper\IAM\EventHandlers\PermissionsDeletedEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class PermissionsDeletedEvent
 *
 * @package PlusClouds\Account\Handlers\Events
 */
class PermissionsDeletedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}