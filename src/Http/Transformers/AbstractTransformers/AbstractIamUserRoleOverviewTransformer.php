<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\IamUserRoleOverview;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class IamUserRoleOverviewTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractIamUserRoleOverviewTransformer extends AbstractTransformer {

    /**
     * @param IamUserRoleOverview $model
     *
     * @return array
     */
    public function transform(IamUserRoleOverview $model) {
                        $iamRoleId = \NextDeveloper\IAM\Database\Models\IamRole::where('id', $model->iam_role_id)->first();
                    $iamUserId = \NextDeveloper\IAM\Database\Models\IamUser::where('id', $model->iam_user_id)->first();
                    $iamAccountId = \NextDeveloper\IAM\Database\Models\IamAccount::where('id', $model->iam_account_id)->first();
            
        return $this->buildPayload([
'id'  =>  $model->uuid,
'name'  =>  $model->name,
'class'  =>  $model->class,
'level'  =>  $model->level,
'description'  =>  $model->description,
'created_at'  =>  $model->created_at,
'updated_at'  =>  $model->updated_at,
'deleted_at'  =>  $model->deleted_at,
'iam_role_id'  =>  $iamRoleId ? $iamRoleId->uuid : null,
'iam_user_id'  =>  $iamUserId ? $iamUserId->uuid : null,
'iam_account_id'  =>  $iamAccountId ? $iamAccountId->uuid : null,
'is_active'  =>  $model->is_active,
'role_data'  =>  $model->role_data,
    ]);
    }
    
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
