<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\Backends;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractBackendsTransformer;

/**
 * Class BackendsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class BackendsTransformer extends AbstractBackendsTransformer {

    /**
     * @param Backends $model
     *
     * @return array
     */
    public function transform(Backends $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('Backends', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('Backends', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
