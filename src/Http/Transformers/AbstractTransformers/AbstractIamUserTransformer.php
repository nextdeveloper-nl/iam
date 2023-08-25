<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\IamUser;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class IamUserTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractIamUserTransformer extends AbstractTransformer {

    /**
     * @param IamUser $model
     *
     * @return array
     */
    public function transform(IamUser $model) {
                        $commonLanguageId = \NextDeveloper\Commons\Database\Models\CommonLanguage::where('id', $model->common_language_id)->first();
                    $commonCountryId = \NextDeveloper\Commons\Database\Models\CommonCountry::where('id', $model->common_country_id)->first();
            
        return $this->buildPayload([
'id'  =>  $model->uuid,
'name'  =>  $model->name,
'surname'  =>  $model->surname,
'email'  =>  $model->email,
'fullname'  =>  $model->fullname,
'username'  =>  $model->username,
'about'  =>  $model->about,
'gender'  =>  $model->gender,
'birthday'  =>  $model->birthday,
'nin'  =>  $model->nin,
'cell_phone'  =>  $model->cell_phone,
'common_language_id'  =>  $commonLanguageId ? $commonLanguageId->uuid : null,
'common_country_id'  =>  $commonCountryId ? $commonCountryId->uuid : null,
'created_at'  =>  $model->created_at,
'updated_at'  =>  $model->updated_at,
'deleted_at'  =>  $model->deleted_at,
    ]);
    }
    
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n


}
