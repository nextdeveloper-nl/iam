<?php

namespace NextDeveloper\IAM\Events\IamAccountUser;

use Illuminate\Queue\SerializesModels;
use NextDeveloper\IAM\Database\Models\IamAccountUser;

/**
 * Class IamAccountUserRestoringEvent
 * @package NextDeveloper\IAM\Events
 */
class IamAccountUserRestoringEvent
{
    use SerializesModels;

    /**
     * @var IamAccountUser
     */
    public $_model;

    /**
     * @var int|null
     */
    protected $timestamp = null;

    public function __construct(IamAccountUser $model = null) {
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