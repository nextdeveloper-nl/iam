<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\IamBackend;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractIamBackendTransformer;

/**
 * Class IamBackendTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamBackendTransformer extends AbstractIamBackendTransformer {

    /**
     * @param IamBackend $model
     *
     * @return array
     */
    public function transform(IamBackend $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('IamBackend', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('IamBackend', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
