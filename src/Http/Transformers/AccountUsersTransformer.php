<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\AccountUsers;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractAccountUsersTransformer;

/**
 * Class AccountUsersTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AccountUsersTransformer extends AbstractAccountUsersTransformer {

    /**
     * @param AccountUsers $model
     *
     * @return array
     */
    public function transform(AccountUsers $model) {
        $transformed = Cache::get(
            CacheHelper::getKey('AccountUsers', $model->uuid, 'Transformed')
        );

        if($transformed)
            return $transformed;

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('AccountUsers', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
