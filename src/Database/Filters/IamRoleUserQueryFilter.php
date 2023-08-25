<?php

namespace NextDeveloper\IAM\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;
use NextDeveloper\Accounts\Database\Models\User;
        

/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class IamRoleUserQueryFilter extends AbstractQueryFilter
{
    /**
    * @var Builder
    */
    protected $builder;

    public function isActive()
    {
        return $this->builder->where('is_active', true);
    }
    
    public function iamRoleId($value)
    {
        $iamRole = IamRole::where('uuid', $value)->first();

        if($iamRole) {
            return $this->builder->where('iam_role_id', '=', $iamRole->id);
        }
    }

    public function iamUserId($value)
    {
        $iamUser = IamUser::where('uuid', $value)->first();

        if($iamUser) {
            return $this->builder->where('iam_user_id', '=', $iamUser->id);
        }
    }

    public function iamAccountId($value)
    {
        $iamAccount = IamAccount::where('uuid', $value)->first();

        if($iamAccount) {
            return $this->builder->where('iam_account_id', '=', $iamAccount->id);
        }
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}