<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\IamAccountUser;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractIamAccountUserTransformer;

/**
 * Class IamAccountUserTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamAccountUserTransformer extends AbstractIamAccountUserTransformer {

    /**
     * @param IamAccountUser $model
     *
     * @return array
     */
    public function transform(IamAccountUser $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('IamAccountUser', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('IamAccountUser', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
