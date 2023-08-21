<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\IamUserAccountOverview;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractIamUserAccountOverviewTransformer;

/**
 * Class IamUserAccountOverviewTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamUserAccountOverviewTransformer extends AbstractIamUserAccountOverviewTransformer {

    /**
     * @param IamUserAccountOverview $model
     *
     * @return array
     */
    public function transform(IamUserAccountOverview $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('IamUserAccountOverview', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('IamUserAccountOverview', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
