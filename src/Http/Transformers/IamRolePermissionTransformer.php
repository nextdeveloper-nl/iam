<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\IamRolePermission;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractIamRolePermissionTransformer;

/**
 * Class IamRolePermissionTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamRolePermissionTransformer extends AbstractIamRolePermissionTransformer {

    /**
     * @param IamRolePermission $model
     *
     * @return array
     */
    public function transform(IamRolePermission $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('IamRolePermission', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('IamRolePermission', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
