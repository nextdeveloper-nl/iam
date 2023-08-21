<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\IamUserAccountOverview;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class IamUserAccountOverviewTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractIamUserAccountOverviewTransformer extends AbstractTransformer {

    /**
     * @param IamUserAccountOverview $model
     *
     * @return array
     */
    public function transform(IamUserAccountOverview $model) {
                        $languageId = \NextDeveloper\\Database\Models\Language::where('id', $model->language_id)->first();
                    $countryId = \NextDeveloper\\Database\Models\Country::where('id', $model->country_id)->first();
                    $userId = \NextDeveloper\\Database\Models\User::where('id', $model->user_id)->first();
                    $accountId = \NextDeveloper\\Database\Models\Account::where('id', $model->account_id)->first();
            
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
'language_id'  =>  $languageId ? $languageId->uuid : null,
'country_id'  =>  $countryId ? $countryId->uuid : null,
'created_at'  =>  $model->created_at,
'updated_at'  =>  $model->updated_at,
'deleted_at'  =>  $model->deleted_at,
'user_id'  =>  $userId ? $userId->uuid : null,
'account_id'  =>  $accountId ? $accountId->uuid : null,
'is_active'  =>  $model->is_active,
'session_data'  =>  $model->session_data,
    ]);
    }
    
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
