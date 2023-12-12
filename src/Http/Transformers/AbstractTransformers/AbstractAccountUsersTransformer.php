<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\AccountUsers;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class AccountUsersTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractAccountUsersTransformer extends AbstractTransformer
{

    /**
     * @param AccountUsers $model
     *
     * @return array
     */
    public function transform(AccountUsers $model)
    {
                        $commonLanguageId = \NextDeveloper\Commons\Database\Models\Languages::where('id', $model->common_language_id)->first();
                    $commonCountryId = \NextDeveloper\Commons\Database\Models\Countries::where('id', $model->common_country_id)->first();
                    $iamAccountId = \NextDeveloper\IAM\Database\Models\Accounts::where('id', $model->iam_account_id)->first();
        
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
            'cell_phone'  =>  $model->cell_phone,
            'common_language_id'  =>  $commonLanguageId ? $commonLanguageId->uuid : null,
            'common_country_id'  =>  $commonCountryId ? $commonCountryId->uuid : null,
            'created_at'  =>  $model->created_at ? $model->created_at->toIso8601String() : null,
            'updated_at'  =>  $model->updated_at ? $model->updated_at->toIso8601String() : null,
            'deleted_at'  =>  $model->deleted_at ? $model->deleted_at->toIso8601String() : null,
            'iam_account_id'  =>  $iamAccountId ? $iamAccountId->uuid : null,
            'is_active'  =>  $model->is_active,
            'session_data'  =>  $model->session_data,
            ]
        );
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n

















}
