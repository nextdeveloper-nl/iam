<?php

namespace NextDeveloper\IAM\Events\RoleUsers;

use Illuminate\Queue\SerializesModels;
use NextDeveloper\IAM\Database\Models\RoleUsers;

/**
 * Class RoleUserDeletingEvent
 * @package NextDeveloper\IAM\Events
 */
class RoleUserDeletingEvent
{
    use SerializesModels;

    /**
     * @var RoleUsers
     */
    public $_model;

    /**
     * @var int|null
     */
    protected $timestamp = null;

    public function __construct(RoleUsers $model = null) {
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