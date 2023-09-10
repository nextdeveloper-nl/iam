<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\Permissions;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractPermissionsTransformer;

/**
 * Class PermissionsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class PermissionsTransformer extends AbstractPermissionsTransformer {

    /**
     * @param Permissions $model
     *
     * @return array
     */
    public function transform(Permissions $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('Permissions', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('Permissions', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
