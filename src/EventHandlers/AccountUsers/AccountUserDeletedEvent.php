<?php

namespace NextDeveloper\IAM\EventHandlers\AccountUserDeletedEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class AccountUserDeletedEvent
 *
 * @package PlusClouds\Account\Handlers\Events
 */
class AccountUserDeletedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}