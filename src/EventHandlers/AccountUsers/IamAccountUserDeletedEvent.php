<?php

namespace NextDeveloper\IAM\EventHandlers\AccountUsers;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class IamAccountUserDeletedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamAccountUserDeletedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}