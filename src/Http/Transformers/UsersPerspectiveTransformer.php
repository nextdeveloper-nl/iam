<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\UsersPerspective;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractUsersPerspectiveTransformer;

/**
 * Class UsersPerspectiveTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class UsersPerspectiveTransformer extends AbstractUsersPerspectiveTransformer
{

    /**
     * @param UsersPerspective $model
     *
     * @return array
     */
    public function transform(UsersPerspective $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('UsersPerspective', $model->uuid, 'Transformed')
        );

        if($transformed) {
            //return $transformed;
        }

        $transformed = parent::transform($model);

        // Add a profile picture url
        $transformed['profile_picture_url'] = UserHelper::getUsersProfilePictureUrl(
            $transformed['email'],
            $transformed['profile_picture_identity'] ?? null
        );


        Cache::set(
            CacheHelper::getKey('UsersPerspective', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
