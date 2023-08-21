<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\IamUserRoleOverview;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractIamUserRoleOverviewTransformer;

/**
 * Class IamUserRoleOverviewTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class IamUserRoleOverviewTransformer extends AbstractIamUserRoleOverviewTransformer {

    /**
     * @param IamUserRoleOverview $model
     *
     * @return array
     */
    public function transform(IamUserRoleOverview $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('IamUserRoleOverview', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('IamUserRoleOverview', $model->uuid, 'Transformed'),
            $transformed
        );

        return parent::transform($model);
    }
}
