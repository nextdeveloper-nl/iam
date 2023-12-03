<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class LoginMechanismsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractLoginMechanismsTransformer extends AbstractTransformer
{

    /**
     * @param LoginMechanisms $model
     *
     * @return array
     */
    public function transform(LoginMechanisms $model)
    {
                        $iamUserId = \NextDeveloper\IAM\Database\Models\Users::where('id', $model->iam_user_id)->first();
        
        return $this->buildPayload(
            [
            'id'  =>  $model->uuid,
            'iam_user_id'  =>  $iamUserId ? $iamUserId->uuid : null,
            'login_client'  =>  $model->login_client,
            'login_data'  =>  $model->login_data,
            'login_mechanism'  =>  $model->login_mechanism,
            'is_latest'  =>  $model->is_latest == 1 ? true : false,
            'is_default'  =>  $model->is_default == 1 ? true : false,
            'is_active'  =>  $model->is_active == 1 ? true : false,
            'created_at'  =>  $model->created_at ? $model->created_at->toIso8601String() : null,
            'updated_at'  =>  $model->updated_at ? $model->updated_at->toIso8601String() : null,
            'deleted_at'  =>  $model->deleted_at ? $model->deleted_at->toIso8601String() : null,
            ]
        );
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n


}
