<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\RoleUsers;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class RoleUsersTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractRoleUsersTransformer extends AbstractTransformer
{

    /**
     * @param RoleUsers $model
     *
     * @return array
     */
    public function transform(RoleUsers $model)
    {
                        $iamRoleId = \NextDeveloper\IAM\Database\Models\Roles::where('id', $model->iam_role_id)->first();
                    $iamUserId = \NextDeveloper\IAM\Database\Models\Users::where('id', $model->iam_user_id)->first();
                    $iamAccountId = \NextDeveloper\IAM\Database\Models\Accounts::where('id', $model->iam_account_id)->first();
        
        return $this->buildPayload(
            [
            'id'  =>  $model->uuid,
            'iam_role_id'  =>  $iamRoleId ? $iamRoleId->uuid : null,
            'iam_user_id'  =>  $iamUserId ? $iamUserId->uuid : null,
            'iam_account_id'  =>  $iamAccountId ? $iamAccountId->uuid : null,
            'is_active'  =>  $model->is_active,
            'role_data'  =>  $model->role_data,
            ]
        );
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n

































}
