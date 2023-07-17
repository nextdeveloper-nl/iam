<?php

namespace NextDeveloper\IAM\Events\IamAccount;

use Illuminate\Queue\SerializesModels;
use NextDeveloper\IAM\Database\Models\IamAccount;

/**
 * Class IamAccountUpdatingEvent
 * @package NextDeveloper\IAM\Events
 */
class IamAccountUpdatingEvent
{
    use SerializesModels;

    /**
     * @var IamAccount
     */
    public $_model;

    /**
     * @var int|null
     */
    protected $timestamp = null;

    public function __construct(IamAccount $model = null) {
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