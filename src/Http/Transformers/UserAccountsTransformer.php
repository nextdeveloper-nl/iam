<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\UserAccounts;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractUserAccountsTransformer;

/**
 * Class UserAccountsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class UserAccountsTransformer extends AbstractUserAccountsTransformer {

    /**
     * @param UserAccounts $model
     *
     * @return array
     */
    public function transform(UserAccounts $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('UserAccounts', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('UserAccounts', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
