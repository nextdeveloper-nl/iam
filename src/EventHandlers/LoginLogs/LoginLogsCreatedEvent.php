<?php

namespace NextDeveloper\IAM\EventHandlers\LoginLogsCreatedEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class LoginLogsCreatedEvent
 *
 * @package PlusClouds\Account\Handlers\Events
 */
class LoginLogsCreatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
