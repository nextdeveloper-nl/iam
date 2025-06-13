<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\LoginLogs;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractLoginLogsTransformer;

/**
 * Class LoginLogsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class LoginLogsTransformer extends AbstractLoginLogsTransformer
{

    /**
     * @param LoginLogs $model
     *
     * @return array
     */
    public function transform(LoginLogs $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('LoginLogs', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('LoginLogs', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
