<?php

namespace NextDeveloper\IAM\EventHandlers\Accounts;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class IamAccountsDeletedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamAccountsDeletedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
