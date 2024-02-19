<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\RolePermissions;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class RolePermissionsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractRolePermissionsTransformer extends AbstractTransformer
{

    /**
     * @param RolePermissions $model
     *
     * @return array
     */
    public function transform(RolePermissions $model)
    {
                        $iamRoleId = \NextDeveloper\IAM\Database\Models\Roles::where('id', $model->iam_role_id)->first();
                    $iamPermissionId = \NextDeveloper\IAM\Database\Models\Permissions::where('id', $model->iam_permission_id)->first();
        
        return $this->buildPayload(
            [
            'id'  =>  $model->uuid,
            'iam_role_id'  =>  $iamRoleId ? $iamRoleId->uuid : null,
            'iam_permission_id'  =>  $iamPermissionId ? $iamPermissionId->uuid : null,
            'is_active'  =>  $model->is_active,
            'created_by'  =>  $model->created_by,
            'created_at'  =>  $model->created_at,
            'updated_by'  =>  $model->updated_by,
            'updated_at'  =>  $model->updated_at,
            ]
        );
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n






























}
