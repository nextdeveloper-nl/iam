<?php

namespace NextDeveloper\IAM\Events\Roles;

use Illuminate\Queue\SerializesModels;
use NextDeveloper\IAM\Database\Models\Roles;

/**
 * Class RolesSavingEvent
 * @package NextDeveloper\IAM\Events
 */
class RolesSavingEvent
{
    use SerializesModels;

    /**
     * @var Roles
     */
    public $_model;

    /**
     * @var int|null
     */
    protected $timestamp = null;

    public function __construct(Roles $model = null) {
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