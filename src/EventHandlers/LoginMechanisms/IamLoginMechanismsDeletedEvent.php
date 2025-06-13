<?php

namespace NextDeveloper\IAM\EventHandlers\LoginMechanisms;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class IamLoginMechanismsDeletedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamLoginMechanismsDeletedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
