<?php

namespace NextDeveloper\IAM\Http\Transformers;

use NextDeveloper\IAM\Database\Models\IamLoginMechanism;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class IamLoginMechanismTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamLoginMechanismTransformer extends AbstractTransformer {

    /**
     * @param IamLoginMechanism $model
     *
     * @return array
     */
    public function transform(IamLoginMechanism $model) {
        return $this->buildPayload([
            'id'  =>  $model->uuid,
            'user_id'  =>  $model->user_id,
            'login_client'  =>  $model->login_client,
            'login_data'  =>  $model->login_data,
            'login_mechanism'  =>  $model->login_mechanism,
            'is_latest'  =>  $model->is_latest == 1 ? true : false,
            'is_default'  =>  $model->is_default == 1 ? true : false,
            'is_active'  =>  $model->is_active == 1 ? true : false,
            'created_at'  =>  $model->created_at,
            'updated_at'  =>  $model->updated_at,
            'deleted_at'  =>  $model->deleted_at,
        ]);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}