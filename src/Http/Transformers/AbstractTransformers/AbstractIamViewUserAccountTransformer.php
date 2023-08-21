<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\IamViewUserAccount;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class IamViewUserAccountTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractIamViewUserAccountTransformer extends AbstractTransformer {

    /**
     * @param IamViewUserAccount $model
     *
     * @return array
     */
    public function transform(IamViewUserAccount $model) {
                        $commonDomainId = \NextDeveloper\Commons\Database\Models\CommonDomain::where('id', $model->common_domain_id)->first();
                    $commonCountryId = \NextDeveloper\Commons\Database\Models\CommonCountry::where('id', $model->common_country_id)->first();
                    $iamUserId = \NextDeveloper\IAM\Database\Models\IamUser::where('id', $model->iam_user_id)->first();
                    $iamAccountTypeId = \NextDeveloper\IAM\Database\Models\IamAccountType::where('id', $model->iam_account_type_id)->first();
                    $memberId = \NextDeveloper\\Database\Models\Member::where('id', $model->member_id)->first();
            
        return $this->buildPayload([
'id'  =>  $model->uuid,
'name'  =>  $model->name,
'common_domain_id'  =>  $commonDomainId ? $commonDomainId->uuid : null,
'common_country_id'  =>  $commonCountryId ? $commonCountryId->uuid : null,
'phone_number'  =>  $model->phone_number,
'description'  =>  $model->description,
'iam_user_id'  =>  $iamUserId ? $iamUserId->uuid : null,
'iam_account_type_id'  =>  $iamAccountTypeId ? $iamAccountTypeId->uuid : null,
'created_at'  =>  $model->created_at,
'updated_at'  =>  $model->updated_at,
'deleted_at'  =>  $model->deleted_at,
'member_id'  =>  $memberId ? $memberId->uuid : null,
    ]);
    }
    
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
