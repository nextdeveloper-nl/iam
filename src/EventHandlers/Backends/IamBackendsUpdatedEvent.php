<?php

namespace NextDeveloper\IAM\EventHandlers\Backends;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class IamBackendsUpdatedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamBackendsUpdatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}