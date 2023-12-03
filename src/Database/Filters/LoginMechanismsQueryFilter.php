<?php

namespace NextDeveloper\IAM\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;
use NextDeveloper\Accounts\Database\Models\User;
    

/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class LoginMechanismsQueryFilter extends AbstractQueryFilter
{
    /**
     * @var Builder
     */
    protected $builder;
    
    public function loginClient($value)
    {
        return $this->builder->where('login_client', 'like', '%' . $value . '%');
    }
    
    public function loginMechanism($value)
    {
        return $this->builder->where('login_mechanism', 'like', '%' . $value . '%');
    }

    public function isLatest()
    {
        return $this->builder->where('is_latest', true);
    }
    
    public function isDefault()
    {
        return $this->builder->where('is_default', true);
    }
    
    public function isActive()
    {
        return $this->builder->where('is_active', true);
    }
    
    public function createdAtStart($date) 
    {
        return $this->builder->where('created_at', '>=', $date);
    }

    public function createdAtEnd($date) 
    {
        return $this->builder->where('created_at', '<=', $date);
    }

    public function updatedAtStart($date) 
    {
        return $this->builder->where('updated_at', '>=', $date);
    }

    public function updatedAtEnd($date) 
    {
        return $this->builder->where('updated_at', '<=', $date);
    }

    public function deletedAtStart($date) 
    {
        return $this->builder->where('deleted_at', '>=', $date);
    }

    public function deletedAtEnd($date) 
    {
        return $this->builder->where('deleted_at', '<=', $date);
    }

    public function iamUserId($value)
    {
            $iamUser = \NextDeveloper\IAM\Database\Models\Users::where('uuid', $value)->first();

        if($iamUser) {
            return $this->builder->where('iam_user_id', '=', $iamUser->id);
        }
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}