<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\IamRoleUser;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class IamRoleUserTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractIamRoleUserTransformer extends AbstractTransformer {

    /**
     * @param IamRoleUser $model
     *
     * @return array
     */
    public function transform(IamRoleUser $model) {
                        $iamRoleId = \NextDeveloper\IAM\Database\Models\IamRole::where('id', $model->iam_role_id)->first();
                    $iamUserId = \NextDeveloper\IAM\Database\Models\IamUser::where('id', $model->iam_user_id)->first();
                    $iamAccountId = \NextDeveloper\IAM\Database\Models\IamAccount::where('id', $model->iam_account_id)->first();
            
        return $this->buildPayload([
'id'  =>  $model->id,
'iam_role_id'  =>  $iamRoleId ? $iamRoleId->uuid : null,
'iam_user_id'  =>  $iamUserId ? $iamUserId->uuid : null,
'iam_account_id'  =>  $iamAccountId ? $iamAccountId->uuid : null,
'is_active'  =>  $model->is_active,
'role_data'  =>  $model->role_data,
    ]);
    }
    
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n


}
