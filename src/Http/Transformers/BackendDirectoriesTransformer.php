<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\BackendDirectories;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractBackendDirectoriesTransformer;

/**
 * Class BackendDirectoriesTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class BackendDirectoriesTransformer extends AbstractBackendDirectoriesTransformer
{

    /**
     * @param BackendDirectories $model
     *
     * @return array
     */
    public function transform(BackendDirectories $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('BackendDirectories', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('BackendDirectories', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
