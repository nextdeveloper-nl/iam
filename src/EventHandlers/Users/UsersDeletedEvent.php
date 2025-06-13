<?php

namespace NextDeveloper\IAM\EventHandlers\UsersDeletedEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class UsersDeletedEvent
 *
 * @package PlusClouds\Account\Handlers\Events
 */
class UsersDeletedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
