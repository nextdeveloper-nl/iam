<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\SshPublicKeys;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractSshPublicKeysTransformer;

/**
 * Class SshPublicKeysTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class SshPublicKeysTransformer extends AbstractSshPublicKeysTransformer
{

    /**
     * @param SshPublicKeys $model
     *
     * @return array
     */
    public function transform(SshPublicKeys $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('SshPublicKeys', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('SshPublicKeys', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
