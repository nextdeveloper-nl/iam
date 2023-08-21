<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\IamRoleUser;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractIamRoleUserTransformer;

/**
 * Class IamRoleUserTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamRoleUserTransformer extends AbstractIamRoleUserTransformer {

    /**
     * @param IamRoleUser $model
     *
     * @return array
     */
    public function transform(IamRoleUser $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('IamRoleUser', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('IamRoleUser', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
