<?php

namespace NextDeveloper\IAM\Events\IamRoleUser;

use Illuminate\Queue\SerializesModels;
use NextDeveloper\IAM\Database\Models\IamRoleUser;

/**
 * Class IamRoleUserCreatedEvent
 * @package NextDeveloper\IAM\Events
 */
class IamRoleUserCreatedEvent
{
    use SerializesModels;

    /**
     * @var IamRoleUser
     */
    public $_model;

    /**
     * @var int|null
     */
    protected $timestamp = null;

    public function __construct(IamRoleUser $model = null) {
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