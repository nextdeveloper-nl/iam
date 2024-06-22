<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\AccountsOverviews;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractAccountsOverviewsTransformer;

/**
 * Class AccountsOverviewsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AccountsOverviewsTransformer extends AbstractAccountsOverviewsTransformer
{

    /**
     * @param AccountsOverviews $model
     *
     * @return array
     */
    public function transform(AccountsOverviews $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('AccountsOverviews', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('AccountsOverviews', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
