<?php

namespace NextDeveloper\IAM\EventHandlers\AccountUserCreatedEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class AccountUserCreatedEvent
 *
 * @package PlusClouds\Account\Handlers\Events
 */
class AccountUserCreatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
