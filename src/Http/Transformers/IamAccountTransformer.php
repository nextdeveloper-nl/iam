<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\IamAccount;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractIamAccountTransformer;

/**
 * Class IamAccountTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamAccountTransformer extends AbstractIamAccountTransformer {

    /**
     * @param IamAccount $model
     *
     * @return array
     */
    public function transform(IamAccount $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('IamAccount', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('IamAccount', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
