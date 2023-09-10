<?php

namespace NextDeveloper\IAM\Events\AccountUsers;

use Illuminate\Queue\SerializesModels;
use NextDeveloper\IAM\Database\Models\AccountUsers;

/**
 * Class AccountUserDeletingEvent
 * @package NextDeveloper\IAM\Events
 */
class AccountUserDeletingEvent
{
    use SerializesModels;

    /**
     * @var AccountUsers
     */
    public $_model;

    /**
     * @var int|null
     */
    protected $timestamp = null;

    public function __construct(AccountUsers $model = null) {
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