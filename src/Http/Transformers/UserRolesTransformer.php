<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\UserRoles;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractUserRolesTransformer;

/**
 * Class UserRolesTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class UserRolesTransformer extends AbstractUserRolesTransformer
{

    /**
     * @param UserRoles $model
     *
     * @return array
     */
    public function transform(UserRoles $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('UserRoles', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('UserRoles', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
