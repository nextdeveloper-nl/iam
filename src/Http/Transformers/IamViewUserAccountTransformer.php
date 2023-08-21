<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\IamViewUserAccount;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractIamViewUserAccountTransformer;

/**
 * Class IamViewUserAccountTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamViewUserAccountTransformer extends AbstractIamViewUserAccountTransformer {

    /**
     * @param IamViewUserAccount $model
     *
     * @return array
     */
    public function transform(IamViewUserAccount $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('IamViewUserAccount', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('IamViewUserAccount', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
