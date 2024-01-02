<?php

namespace NextDeveloper\IAM\Events\AccountTypes;

use Illuminate\Queue\SerializesModels;
use NextDeveloper\IAM\Database\Models\AccountTypes;

/**
 * Class AccountTypesCreatedEvent
 * @package NextDeveloper\IAM\Events
 */
class AccountTypesCreatedEvent
{
    use SerializesModels;

    /**
     * @var AccountTypes
     */
    public $_model;

    /**
     * @var int|null
     */
    protected $timestamp = null;

    public function __construct(AccountTypes $model = null) {
        $this->_model = $model;
    }

    /**
    * @param int $value
    *
    * @return AbstractEvent
    */
    public function setTimestamp($value) {
        $this->timestamp = $value;

        return $this;
    }

    /**
    * @return int|null
    */
    public function getTimestamp() {
        return $this->timestamp;
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}