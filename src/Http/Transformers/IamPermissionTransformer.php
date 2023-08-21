<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\IamPermission;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractIamPermissionTransformer;

/**
 * Class IamPermissionTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamPermissionTransformer extends AbstractIamPermissionTransformer {

    /**
     * @param IamPermission $model
     *
     * @return array
     */
    public function transform(IamPermission $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('IamPermission', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('IamPermission', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
