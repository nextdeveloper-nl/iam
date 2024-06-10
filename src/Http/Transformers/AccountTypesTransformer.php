<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\AccountTypes;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractAccountTypesTransformer;

/**
 * Class AccountTypesTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AccountTypesTransformer extends AbstractAccountTypesTransformer {

    /**
     * @param AccountTypes $model
     *
     * @return array
     */
    public function transform(AccountTypes $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('AccountTypes', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('AccountTypes', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
