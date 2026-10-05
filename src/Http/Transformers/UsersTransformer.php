<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Database\Models\Media;
use NextDeveloper\IAM\AuthenticationGrants\Password;
use NextDeveloper\IAM\AuthenticationGrants\QrBadge;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractUsersTransformer;

/**
 * Class UsersTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class UsersTransformer extends AbstractUsersTransformer
{

    /**
     * @param Users $model
     *
     * @return array
     */
    public function transform(Users $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('Users', $model->uuid, 'Transformed')
        );

//        if($transformed) {
//            return $transformed;
//        }

        $transformed = parent::transform($model);

        // Get a profile picture url
        $transformed['profile_picture_url'] = UserHelper::getUsersProfilePictureUrl(
            $transformed['email'],
            $transformed['profile_picture_identity'] ?? null
        );

        Cache::set(
            CacheHelper::getKey('Users', $model->uuid, 'Transformed'),
            $transformed
        );

        //  Sign-in state changes outside the user record, so it is added after caching.
        $transformed['has_password'] = Password::hasPassword($model);
        $transformed['has_qr_badge'] = QrBadge::hasBadge($model);

        return $transformed;
    }
}
