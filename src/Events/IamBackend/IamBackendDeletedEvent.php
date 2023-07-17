<?php

namespace NextDeveloper\IAM\Events\IamBackend;

use Illuminate\Queue\SerializesModels;
use NextDeveloper\IAM\Database\Models\IamBackend;

/**
 * Class IamBackendDeletedEvent
 * @package NextDeveloper\IAM\Events
 */
class IamBackendDeletedEvent
{
    use SerializesModels;

    /**
     * @var IamBackend
     */
    public $_model;

    /**
     * @var int|null
     */
    protected $timestamp = null;

    public function __construct(IamBackend $model = null) {
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