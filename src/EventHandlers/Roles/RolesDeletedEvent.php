<?php

namespace NextDeveloper\IAM\EventHandlers\RolesDeletedEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class RolesDeletedEvent
 *
 * @package PlusClouds\Account\Handlers\Events
 */
class RolesDeletedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
