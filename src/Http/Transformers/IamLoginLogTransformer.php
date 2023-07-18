<?php

namespace NextDeveloper\IAM\Http\Transformers;

use NextDeveloper\IAM\Database\Models\IamLoginLog;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class IamLoginLogTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamLoginLogTransformer extends AbstractTransformer {

    /**
     * @param IamLoginLog $model
     *
     * @return array
     */
    public function transform(IamLoginLog $model) {
        return $this->buildPayload([
            'id'  =>  $model->uuid,
            'user_id'  =>  $model->user_id,
            'log'  =>  $model->log,
            'created_at'  =>  $model->created_at,
        ]);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}