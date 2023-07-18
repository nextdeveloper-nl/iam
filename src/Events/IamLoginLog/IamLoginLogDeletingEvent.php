<?php

namespace NextDeveloper\IAM\Events\IamLoginLog;

use Illuminate\Queue\SerializesModels;
use NextDeveloper\IAM\Database\Models\IamLoginLog;

/**
 * Class IamLoginLogDeletingEvent
 * @package NextDeveloper\IAM\Events
 */
class IamLoginLogDeletingEvent
{
    use SerializesModels;

    /**
     * @var IamLoginLog
     */
    public $_model;

    /**
     * @var int|null
     */
    protected $timestamp = null;

    public function __construct(IamLoginLog $model = null) {
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