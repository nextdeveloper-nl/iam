<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class UsersTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractUsersTransformer extends AbstractTransformer
{

    /**
     * @param Users $model
     *
     * @return array
     */
    public function transform(Users $model)
    {
                        $commonLanguageId = \NextDeveloper\Commons\Database\Models\Languages::where('id', $model->common_language_id)->first();
                    $commonCountryId = \NextDeveloper\Commons\Database\Models\Countries::where('id', $model->common_country_id)->first();
                    $profilePictureId = \NextDeveloper\Commons\Database\Models\Media::where('id', $model->profile_picture_id)->first();
        
        return $this->buildPayload(
            [
            'id'  =>  $model->uuid,
            'name'  =>  $model->name,
            'surname'  =>  $model->surname,
            'email'  =>  $model->email,
            'fullname'  =>  $model->fullname,
            'username'  =>  $model->username,
            'about'  =>  $model->about,
            'pronoun'  =>  $model->pronoun,
            'birthday'  =>  $model->birthday,
            'nin'  =>  $model->nin,
            'common_language_id'  =>  $commonLanguageId ? $commonLanguageId->uuid : null,
            'common_country_id'  =>  $commonCountryId ? $commonCountryId->uuid : null,
            'phone_number'  =>  $model->phone_number,
            'tags'  =>  $model->tags,
            'created_at'  =>  $model->created_at,
            'updated_at'  =>  $model->updated_at,
            'deleted_at'  =>  $model->deleted_at,
            'profile_picture_id'  =>  $profilePictureId ? $profilePictureId->uuid : null,
            ]
        );
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE





}
