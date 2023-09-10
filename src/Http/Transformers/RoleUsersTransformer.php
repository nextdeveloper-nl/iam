<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\RoleUsers;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractRoleUsersTransformer;

/**
 * Class RoleUsersTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class RoleUsersTransformer extends AbstractRoleUsersTransformer {

    /**
     * @param RoleUsers $model
     *
     * @return array
     */
    public function transform(RoleUsers $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('RoleUsers', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('RoleUsers', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
