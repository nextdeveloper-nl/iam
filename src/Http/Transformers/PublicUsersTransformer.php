<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Database\Models\Media;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractUsersTransformer;

/**
 * Class UsersTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class PublicUsersTransformer extends AbstractUsersTransformer
{

    /**
     * @param Users $model
     *
     * @return array
     */
    public function transform(Users $model)
    {
        $transformed = parent::transform($model);

        unset($transformed['id']);
        unset($transformed['email']);
        unset($transformed['birthday']);
        unset($transformed['nin']);
        unset($transformed['common_language_id']);
        unset($transformed['common_country_id']);
        unset($transformed['phone_number']);
        unset($transformed['created_at']);
        unset($transformed['updated_at']);
        unset($transformed['deleted_at']);
        unset($transformed['is_registered']);

        $transformed['photo_url'] = null;

        if($transformed['profile_picture_identity'] != null) {
            $profilePicture = Media::where('id', $transformed['profile_picture_identity'])->first();

            if($profilePicture != null)
                $transformed['photo_url'] = $profilePicture->cdn_url;
            else
                $transformed['photo_url'] = null;
        }

        unset($transformed['profile_picture_identity']);

        return $transformed;
    }
}
