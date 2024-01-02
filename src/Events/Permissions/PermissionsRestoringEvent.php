<?php

namespace NextDeveloper\IAM\Events\Permissions;

use Illuminate\Queue\SerializesModels;
use NextDeveloper\IAM\Database\Models\Permissions;

/**
 * Class PermissionsRestoringEvent
 * @package NextDeveloper\IAM\Events
 */
class PermissionsRestoringEvent
{
    use SerializesModels;

    /**
     * @var Permissions
     */
    public $_model;

    /**
     * @var int|null
     */
    protected $timestamp = null;

    public function __construct(Permissions $model = null) {
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