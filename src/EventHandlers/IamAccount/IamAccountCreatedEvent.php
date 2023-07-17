<?php

namespace NextDeveloper\IAM\EventHandlers\IamAccount;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class IamAccountCreatedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamAccountCreatedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}