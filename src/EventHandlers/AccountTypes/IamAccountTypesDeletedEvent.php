<?php

namespace NextDeveloper\IAM\EventHandlers\AccountTypes;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class IamAccountTypesDeletedEvent
 * @package PlusClouds\Account\Handlers\Events
 */
class IamAccountTypesDeletedEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {

    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
