<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractLoginMechanismsTransformer;

/**
 * Class LoginMechanismsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class LoginMechanismsTransformer extends AbstractLoginMechanismsTransformer {

    /**
     * @param LoginMechanisms $model
     *
     * @return array
     */
    public function transform(LoginMechanisms $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('LoginMechanisms', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('LoginMechanisms', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
