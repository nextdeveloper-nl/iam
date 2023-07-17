<?php

namespace NextDeveloper\IAM\Http\Transformers;

use NextDeveloper\IAM\Database\Models\IamAccountType;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class IamAccountTypeTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamAccountTypeTransformer extends AbstractTransformer {

    /**
     * @param IamAccountType $model
     *
     * @return array
     */
    public function transform(IamAccountType $model) {
        return $this->buildPayload([
            'id'  =>  $model->uuid,
            'name'  =>  $model->name,
            'description'  =>  $model->description,
            'country_id'  =>  $model->country_id,
        ]);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}