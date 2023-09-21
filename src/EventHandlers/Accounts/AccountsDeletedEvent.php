<?php

namespace NextDeveloper\IAM\EventHandlers\AccountsDeletedEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class AccountsDeletedEvent
 *
 * @package PlusClouds\Account\Handlers\Events
 */
class AccountsDeletedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}