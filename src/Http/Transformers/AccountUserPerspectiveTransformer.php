<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\AccountUsersPerspective;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractAccountUserPerspectiveTransformer;

/**
 * Class AccountUserPerspectiveTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AccountUserPerspectiveTransformer extends AbstractAccountUserPerspectiveTransformer
{

    /**
     * @param AccountUsersPerspective $model
     *
     * @return array
     */
    public function transform(AccountUsersPerspective $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('AccountUserPerspective', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('AccountUserPerspective', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
