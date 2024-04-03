<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\Roles;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractRolesTransformer;

/**
 * Class RolesTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class RolesTransformer extends AbstractRolesTransformer
{

    /**
     * @param Roles $model
     *
     * @return array
     */
    public function transform(Roles $model)
    {
//        $transformed = Cache::get(
//            CacheHelper::getKey('Roles', $model->uuid, 'Transformed')
//        );

//        if($transformed) {
//            return $transformed;
//        }

        $transformed = parent::transform($model);

        $transformed['name'] = Str::title($transformed['name']);

        Cache::set(
            CacheHelper::getKey('Roles', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
