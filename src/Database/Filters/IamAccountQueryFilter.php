<?php

namespace NextDeveloper\IAM\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;
                    

/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class IamAccountQueryFilter extends AbstractQueryFilter
{
    /**
    * @var Builder
    */
    protected $builder;
    
    public function name($value)
    {
        return $this->builder->where('name', 'like', '%' . $value . '%');
    }
    
    public function phoneNumber($value)
    {
        return $this->builder->where('phone_number', 'like', '%' . $value . '%');
    }
    
    public function description($value)
    {
        return $this->builder->where('description', 'like', '%' . $value . '%');
    }

    public function createdAtStart($date) 
    {
        return $this->builder->where( 'created_at', '>=', $date );
    }

    public function createdAtEnd($date) 
    {
        return $this->builder->where( 'created_at', '<=', $date );
    }

    public function updatedAtStart($date) 
    {
        return $this->builder->where( 'updated_at', '>=', $date );
    }

    public function updatedAtEnd($date) 
    {
        return $this->builder->where( 'updated_at', '<=', $date );
    }

    public function deletedAtStart($date) 
    {
        return $this->builder->where( 'deleted_at', '>=', $date );
    }

    public function deletedAtEnd($date) 
    {
        return $this->builder->where( 'deleted_at', '<=', $date );
    }

    public function domainId($value)
    {
        $domain = Domain::where('uuid', $value)->first();

        if($domain) {
            return $this->builder->where('domain_id', '=', $domain->id);
        }
    }

    public function countryId($value)
    {
        $country = Country::where('uuid', $value)->first();

        if($country) {
            return $this->builder->where('country_id', '=', $country->id);
        }
    }

    public function currencyId($value)
    {
        $currency = Currency::where('uuid', $value)->first();

        if($currency) {
            return $this->builder->where('currency_id', '=', $currency->id);
        }
    }

    public function ownerId($value)
    {
        $owner = Owner::where('uuid', $value)->first();

        if($owner) {
            return $this->builder->where('owner_id', '=', $owner->id);
        }
    }

    public function accountTypeId($value)
    {
        $accountType = AccountType::where('uuid', $value)->first();

        if($accountType) {
            return $this->builder->where('account_type_id', '=', $accountType->id);
        }
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}