<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\AccountOverviews;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractAccountOverviewsTransformer;

/**
 * Class AccountOverviewsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AccountOverviewsTransformer extends AbstractAccountOverviewsTransformer
{

    /**
     * @param AccountOverviews $model
     *
     * @return array
     */
    public function transform(AccountOverviews $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('AccountOverviews', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('AccountOverviews', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
