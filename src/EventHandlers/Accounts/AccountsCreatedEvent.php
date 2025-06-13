<?php

namespace NextDeveloper\IAM\EventHandlers\AccountsCreatedEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class AccountsCreatedEvent
 *
 * @package PlusClouds\Account\Handlers\Events
 */
class AccountsCreatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
