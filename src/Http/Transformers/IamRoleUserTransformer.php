<?php

namespace NextDeveloper\IAM\Http\Transformers;

use NextDeveloper\IAM\Database\Models\IamRoleUser;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class IamRoleUserTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamRoleUserTransformer extends AbstractTransformer {

    /**
     * @param IamRoleUser $model
     *
     * @return array
     */
    public function transform(IamRoleUser $model) {
        return $this->buildPayload([
            'id'  =>  $model->id,
            'account_role_id'  =>  $model->account_role_id,
            'user_id'  =>  $model->user_id,
            'account_id'  =>  $model->account_id,
        ]);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}