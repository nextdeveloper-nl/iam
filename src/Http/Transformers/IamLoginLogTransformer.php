<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\IamLoginLog;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractIamLoginLogTransformer;

/**
 * Class IamLoginLogTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamLoginLogTransformer extends AbstractIamLoginLogTransformer {

    /**
     * @param IamLoginLog $model
     *
     * @return array
     */
    public function transform(IamLoginLog $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('IamLoginLog', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('IamLoginLog', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
