<?php

namespace NextDeveloper\IAM\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;
            

/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class AccountUsersPerspectiveQueryFilter extends AbstractQueryFilter
{

    /**
     * @var Builder
     */
    protected $builder;

    public function name($value)
    {
        return $this->builder->where('name', 'ilike', '%' . $value . '%');
    }


    public function surname($value)
    {
        return $this->builder->where('surname', 'ilike', '%' . $value . '%');
    }


    public function email($value)
    {
        return $this->builder->where('email', 'ilike', '%' . $value . '%');
    }


    public function fullname($value)
    {
        return $this->builder->where('fullname', 'ilike', '%' . $value . '%');
    }


    public function username($value)
    {
        return $this->builder->where('username', 'ilike', '%' . $value . '%');
    }


    public function about($value)
    {
        return $this->builder->where('about', 'ilike', '%' . $value . '%');
    }


    public function pronoun($value)
    {
        return $this->builder->where('pronoun', 'ilike', '%' . $value . '%');
    }


    public function nin($value)
    {
        return $this->builder->where('nin', 'ilike', '%' . $value . '%');
    }


    public function phoneNumber($value)
    {
        return $this->builder->where('phone_number', 'ilike', '%' . $value . '%');
    }

        //  This is an alias function of phoneNumber
    public function phone_number($value)
    {
        return $this->phoneNumber($value);
    }

    public function isActive($value)
    {
        return $this->builder->where('is_active', $value);
    }

        //  This is an alias function of isActive
    public function is_active($value)
    {
        return $this->isActive($value);
    }

    public function birthdayStart($date)
    {
        return $this->builder->where('birthday', '>=', $date);
    }

    public function birthdayEnd($date)
    {
        return $this->builder->where('birthday', '<=', $date);
    }

    //  This is an alias function of birthday
    public function birthday_start($value)
    {
        return $this->birthdayStart($value);
    }

    //  This is an alias function of birthday
    public function birthday_end($value)
    {
        return $this->birthdayEnd($value);
    }

    public function createdAtStart($date)
    {
        return $this->builder->where('created_at', '>=', $date);
    }

    public function createdAtEnd($date)
    {
        return $this->builder->where('created_at', '<=', $date);
    }

    //  This is an alias function of createdAt
    public function created_at_start($value)
    {
        return $this->createdAtStart($value);
    }

    //  This is an alias function of createdAt
    public function created_at_end($value)
    {
        return $this->createdAtEnd($value);
    }

    public function updatedAtStart($date)
    {
        return $this->builder->where('updated_at', '>=', $date);
    }

    public function updatedAtEnd($date)
    {
        return $this->builder->where('updated_at', '<=', $date);
    }

    //  This is an alias function of updatedAt
    public function updated_at_start($value)
    {
        return $this->updatedAtStart($value);
    }

    //  This is an alias function of updatedAt
    public function updated_at_end($value)
    {
        return $this->updatedAtEnd($value);
    }

    public function deletedAtStart($date)
    {
        return $this->builder->where('deleted_at', '>=', $date);
    }

    public function deletedAtEnd($date)
    {
        return $this->builder->where('deleted_at', '<=', $date);
    }

    //  This is an alias function of deletedAt
    public function deleted_at_start($value)
    {
        return $this->deletedAtStart($value);
    }

    //  This is an alias function of deletedAt
    public function deleted_at_end($value)
    {
        return $this->deletedAtEnd($value);
    }

    public function commonLanguageId($value)
    {
            $commonLanguage = \NextDeveloper\Commons\Database\Models\Languages::where('uuid', $value)->first();

        if($commonLanguage) {
            return $this->builder->where('common_language_id', '=', $commonLanguage->id);
        }
    }

        //  This is an alias function of commonLanguage
    public function common_language_id($value)
    {
        return $this->commonLanguage($value);
    }

    public function commonCountryId($value)
    {
            $commonCountry = \NextDeveloper\Commons\Database\Models\Countries::where('uuid', $value)->first();

        if($commonCountry) {
            return $this->builder->where('common_country_id', '=', $commonCountry->id);
        }
    }

        //  This is an alias function of commonCountry
    public function common_country_id($value)
    {
        return $this->commonCountry($value);
    }

    public function iamAccountId($value)
    {
            $iamAccount = \NextDeveloper\IAM\Database\Models\Accounts::where('uuid', $value)->first();

        if($iamAccount) {
            return $this->builder->where('iam_account_id', '=', $iamAccount->id);
        }
    }


    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE




}
