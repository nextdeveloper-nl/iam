<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Database\Models\Media;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
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

        $transformed['photo_url'] = null;

        if($transformed['profile_picture_identity'] != null) {
            $profilePicture = Media::where('uuid', $transformed['profile_picture_id'])->first();
            $transformed['photo_url'] = $profilePicture->cdn_url;
        }

        Cache::set(
            CacheHelper::getKey('Users', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
