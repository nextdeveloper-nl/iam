<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\SshPublicKeyEvents;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractSshPublicKeyEventsTransformer;

/**
 * Class SshPublicKeyEventsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class SshPublicKeyEventsTransformer extends AbstractSshPublicKeyEventsTransformer
{

    /**
     * @param SshPublicKeyEvents $model
     *
     * @return array
     */
    public function transform(SshPublicKeyEvents $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('SshPublicKeyEvents', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('SshPublicKeyEvents', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
