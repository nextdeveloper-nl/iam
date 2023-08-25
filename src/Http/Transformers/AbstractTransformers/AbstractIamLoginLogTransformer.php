<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\IamLoginLog;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class IamLoginLogTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractIamLoginLogTransformer extends AbstractTransformer {

    /**
     * @param IamLoginLog $model
     *
     * @return array
     */
    public function transform(IamLoginLog $model) {
                        $iamUserId = \NextDeveloper\IAM\Database\Models\IamUser::where('id', $model->iam_user_id)->first();
            
        return $this->buildPayload([
'id'  =>  $model->uuid,
'iam_user_id'  =>  $iamUserId ? $iamUserId->uuid : null,
'log'  =>  $model->log,
'created_at'  =>  $model->created_at,
    ]);
    }
    
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n


}
