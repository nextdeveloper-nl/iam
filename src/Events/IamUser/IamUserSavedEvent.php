<?php

namespace NextDeveloper\IAM\Events\IamUser;

use Illuminate\Queue\SerializesModels;
use NextDeveloper\IAM\Database\Models\IamUser;

/**
 * Class IamUserSavedEvent
 * @package NextDeveloper\IAM\Events
 */
class IamUserSavedEvent
{
    use SerializesModels;

    /**
     * @var IamUser
     */
    public $_model;

    /**
     * @var int|null
     */
    protected $timestamp = null;

    public function __construct(IamUser $model = null) {
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