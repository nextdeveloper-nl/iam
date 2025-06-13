<?php

namespace NextDeveloper\IAM\EventHandlers\Backends;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class IamBackendsCreatedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamBackendsCreatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
