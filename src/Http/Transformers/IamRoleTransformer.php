<?php

namespace NextDeveloper\IAM\Http\Transformers;

use NextDeveloper\IAM\Database\Models\IamRole;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class IamRoleTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamRoleTransformer extends AbstractTransformer {

    /**
     * @param IamRole $model
     *
     * @return array
     */
    public function transform(IamRole $model) {
        return $this->buildPayload([
            'id'  =>  $model->uuid,
            'name'  =>  $model->name,
            'label'  =>  $model->label,
            'level'  =>  $model->level == 1 ? true : false,
            'description'  =>  $model->description,
            'account_id'  =>  $model->account_id,
            'user_id'  =>  $model->user_id,
            'created_at'  =>  $model->created_at,
            'updated_at'  =>  $model->updated_at,
            'deleted_at'  =>  $model->deleted_at,
        ]);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}