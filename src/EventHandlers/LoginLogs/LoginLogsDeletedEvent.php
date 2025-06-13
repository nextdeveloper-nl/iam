<?php

namespace NextDeveloper\IAM\EventHandlers\LoginLogsDeletedEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class LoginLogsDeletedEvent
 *
 * @package PlusClouds\Account\Handlers\Events
 */
class LoginLogsDeletedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
