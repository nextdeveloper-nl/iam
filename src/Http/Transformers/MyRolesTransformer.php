<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\Roles;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractRolesTransformer;

/**
 * Class RolesTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class MyRolesTransformer extends AbstractRolesTransformer
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
        $transformed['name'] = str_replace('-', ' ', $transformed['name']);

        //  I add has_role to the transformed data so that we can understand if the user has this role or not.
        $myRoles = UserHelper::getRoles();

        $transformed['has_role'] = false;

        foreach ($myRoles as $role) {
            if($role->name == $model->name) {
                $transformed['has_role'] = true;
                break;
            }
        }

        Cache::set(
            CacheHelper::getKey('Roles', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
