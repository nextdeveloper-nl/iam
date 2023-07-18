<?php

namespace NextDeveloper\IAM\EventHandlers\IamLoginLog;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class IamLoginLogCreatedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamLoginLogCreatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}