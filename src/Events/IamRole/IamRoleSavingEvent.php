<?php

namespace NextDeveloper\IAM\Events\IamRole;

use Illuminate\Queue\SerializesModels;
use NextDeveloper\IAM\Database\Models\IamRole;

/**
 * Class IamRoleSavingEvent
 * @package NextDeveloper\IAM\Events
 */
class IamRoleSavingEvent
{
    use SerializesModels;

    /**
     * @var IamRole
     */
    public $_model;

    /**
     * @var int|null
     */
    protected $timestamp = null;

    public function __construct(IamRole $model = null) {
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