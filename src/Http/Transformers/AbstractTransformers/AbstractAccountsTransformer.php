<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class AccountsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractAccountsTransformer extends AbstractTransformer
{

    /**
     * @param Accounts $model
     *
     * @return array
     */
    public function transform(Accounts $model)
    {
                        $commonDomainId = \NextDeveloper\Commons\Database\Models\Domains::where('id', $model->common_domain_id)->first();
                    $commonCountryId = \NextDeveloper\Commons\Database\Models\Countries::where('id', $model->common_country_id)->first();
                    $iamUserId = \NextDeveloper\IAM\Database\Models\Users::where('id', $model->iam_user_id)->first();
                    $iamAccountTypeId = \NextDeveloper\IAM\Database\Models\AccountTypes::where('id', $model->iam_account_type_id)->first();
        
        return $this->buildPayload(
            [
            'id'  =>  $model->uuid,
            'name'  =>  $model->name,
            'common_domain_id'  =>  $commonDomainId ? $commonDomainId->uuid : null,
            'common_country_id'  =>  $commonCountryId ? $commonCountryId->uuid : null,
            'phone_number'  =>  $model->phone_number,
            'description'  =>  $model->description,
            'iam_user_id'  =>  $iamUserId ? $iamUserId->uuid : null,
            'iam_account_type_id'  =>  $iamAccountTypeId ? $iamAccountTypeId->uuid : null,
            'is_active'  =>  $model->is_active,
            'tags'  =>  $model->tags,
            'created_at'  =>  $model->created_at,
            'updated_at'  =>  $model->updated_at,
            'deleted_at'  =>  $model->deleted_at,
            ]
        );
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n















































}
