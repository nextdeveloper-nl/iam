<?php

namespace NextDeveloper\IAM\EventHandlers\IamBackend;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class IamBackendDeletedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamBackendDeletedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}