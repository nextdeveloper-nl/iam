<?php

namespace NextDeveloper\IAM\EventHandlers\LoginLogsCreatedEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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