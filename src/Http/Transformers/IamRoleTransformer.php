<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\IamRole;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractIamRoleTransformer;

/**
 * Class IamRoleTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamRoleTransformer extends AbstractIamRoleTransformer {

    /**
     * @param IamRole $model
     *
     * @return array
     */
    public function transform(IamRole $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('IamRole', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('IamRole', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
