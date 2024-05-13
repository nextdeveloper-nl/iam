<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\Commons\Database\Models\Media;
use NextDeveloper\Commons\Http\Transformers\MediaTransformer;
use NextDeveloper\Commons\Database\Models\AvailableActions;
use NextDeveloper\Commons\Http\Transformers\AvailableActionsTransformer;
use NextDeveloper\Commons\Database\Models\States;
use NextDeveloper\Commons\Http\Transformers\StatesTransformer;
use NextDeveloper\IAM\Database\Models\RolePermissions;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;

/**
 * Class RolePermissionsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractRolePermissionsTransformer extends AbstractTransformer
{

    /**
     * @var array
     */
    protected array $availableIncludes = [
        'states',
        'actions',
        'media'
    ];

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

    public function includeStates(RolePermissions $model)
    {
        $states = States::where('object_type', get_class($model))
            ->where('object_id', $model->id)
            ->get();

        return $this->collection($states, new StatesTransformer());
    }

    public function includeActions(RolePermissions $model)
    {
        $input = get_class($model);
        $input = str_replace('\\Database\\Models', '', $input);

        $actions = AvailableActions::withoutGlobalScope(AuthorizationScope::class)
            ->where('input', $input)
            ->get();

        return $this->collection($actions, new AvailableActionsTransformer());
    }

    public function includeMedia(Datacenters $model)
    {
        $media = Media::where('object_type', get_class($model))
            ->where('object_id', $model->id)
            ->get();

        return $this->collection($media, new MediaTransformer());
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
