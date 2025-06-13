<?php

namespace NextDeveloper\IAM\EventHandlers\LoginLogs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class IamLoginLogsCreatedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamLoginLogsCreatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
