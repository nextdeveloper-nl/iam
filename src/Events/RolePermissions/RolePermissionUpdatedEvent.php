<?php

namespace NextDeveloper\IAM\Events\RolePermissions;

use Illuminate\Queue\SerializesModels;
use NextDeveloper\IAM\Database\Models\RolePermissions;

/**
 * Class RolePermissionUpdatedEvent
 * @package NextDeveloper\IAM\Events
 */
class RolePermissionUpdatedEvent
{
    use SerializesModels;

    /**
     * @var RolePermissions
     */
    public $_model;

    /**
     * @var int|null
     */
    protected $timestamp = null;

    public function __construct(RolePermissions $model = null) {
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