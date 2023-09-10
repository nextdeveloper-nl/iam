<?php

namespace NextDeveloper\IAM\Events\Backends;

use Illuminate\Queue\SerializesModels;
use NextDeveloper\IAM\Database\Models\Backends;

/**
 * Class BackendsCreatingEvent
 * @package NextDeveloper\IAM\Events
 */
class BackendsCreatingEvent
{
    use SerializesModels;

    /**
     * @var Backends
     */
    public $_model;

    /**
     * @var int|null
     */
    protected $timestamp = null;

    public function __construct(Backends $model = null) {
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