<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\IamUser;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractIamUserTransformer;

/**
 * Class IamUserTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamUserTransformer extends AbstractIamUserTransformer {

    /**
     * @param IamUser $model
     *
     * @return array
     */
    public function transform(IamUser $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('IamUser', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('IamUser', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
