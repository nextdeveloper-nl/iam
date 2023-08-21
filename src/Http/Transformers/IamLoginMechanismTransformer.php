<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\IamLoginMechanism;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractIamLoginMechanismTransformer;

/**
 * Class IamLoginMechanismTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamLoginMechanismTransformer extends AbstractIamLoginMechanismTransformer {

    /**
     * @param IamLoginMechanism $model
     *
     * @return array
     */
    public function transform(IamLoginMechanism $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('IamLoginMechanism', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('IamLoginMechanism', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
