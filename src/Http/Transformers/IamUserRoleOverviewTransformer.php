<?php

namespace NextDeveloper\IAM\Http\Transformers;

use NextDeveloper\IAM\Database\Models\IamRoleUser;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Database\Models\IamUserRoleOverview;

/**
 * Class IamRoleUserTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamUserRoleOverviewTransformer extends AbstractTransformer {

    /**
     * @param IamRoleUser $model
     *
     * @return array
     */
    public function transform(IamUserRoleOverview $model) {
        return $this->buildPayload([
            'id'  =>  $model->uuid,
            'name'  =>  $model->name,
            'is_active'  =>  $model->is_active
        ]);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}