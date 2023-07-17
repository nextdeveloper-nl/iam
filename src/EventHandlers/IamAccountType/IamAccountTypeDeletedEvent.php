<?php

namespace NextDeveloper\IAM\EventHandlers\IamAccountType;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class IamAccountTypeDeletedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamAccountTypeDeletedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}