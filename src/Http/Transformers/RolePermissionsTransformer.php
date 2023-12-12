<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\RolePermissions;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractRolePermissionsTransformer;

/**
 * Class RolePermissionsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class RolePermissionsTransformer extends AbstractRolePermissionsTransformer
{

    /**
     * @param RolePermissions $model
     *
     * @return array
     */
    public function transform(RolePermissions $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('RolePermissions', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('RolePermissions', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
