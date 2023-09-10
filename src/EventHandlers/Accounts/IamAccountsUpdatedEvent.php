<?php

namespace NextDeveloper\IAM\EventHandlers\Accounts;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class IamAccountsUpdatedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamAccountsUpdatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}