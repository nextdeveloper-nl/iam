<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\IamRolePermission;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class IamRolePermissionTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractIamRolePermissionTransformer extends AbstractTransformer {

    /**
     * @param IamRolePermission $model
     *
     * @return array
     */
    public function transform(IamRolePermission $model) {
                        $iamRoleId = \NextDeveloper\IAM\Database\Models\IamRole::where('id', $model->iam_role_id)->first();
                    $iamPermissionId = \NextDeveloper\IAM\Database\Models\IamPermission::where('id', $model->iam_permission_id)->first();
            
        return $this->buildPayload([
'id'  =>  $model->id,
'iam_role_id'  =>  $iamRoleId ? $iamRoleId->uuid : null,
'iam_permission_id'  =>  $iamPermissionId ? $iamPermissionId->uuid : null,
'is_active'  =>  $model->is_active == 1 ? true : false,
'created_by'  =>  $model->created_by,
'created_at'  =>  $model->created_at,
'updated_by'  =>  $model->updated_by,
'updated_at'  =>  $model->updated_at,
    ]);
    }
    
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
