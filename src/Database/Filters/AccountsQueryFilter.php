<?php

namespace NextDeveloper\IAM\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Accounts\Database\Models\User;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;
use NextDeveloper\Commons\Database\Filters\FilterClauses;
                

/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class AccountsQueryFilter extends AbstractQueryFilter
{
    /**
     * Filter by tags
     *
     * @param  $values
     * @return Builder
     */
    public function tags($values)
    {
        return FilterClauses::tags($this->builder, $values);
    }

    /**
     * @var Builder
     */
    protected $builder;

    public function name($value)
    {
        return $this->builder->where('name', 'ilike', '%' . $value . '%');
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

    public function description($value)
    {
        return $this->builder->where('description', 'ilike', '%' . $value . '%');
    }


    public function profileImageUrl($value)
    {
        return $this->builder->where('profile_image_url', 'ilike', '%' . $value . '%');
    }

        //  This is an alias function of profileImageUrl
    public function profile_image_url($value)
    {
        return $this->profileImageUrl($value);
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

    public function allowSameDomainJoin($value)
    {
        return $this->builder->where('allow_same_domain_join', $value);
    }

        //  This is an alias function of allowSameDomainJoin
    public function allow_same_domain_join($value)
    {
        return $this->allowSameDomainJoin($value);
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

    public function commonDomainId($value)
    {
        return FilterClauses::linkedId($this->builder, 'common_domain_id', \NextDeveloper\Commons\Database\Models\Domains::class, $value);
    }

        //  This is an alias function of commonDomain
    public function common_domain_id($value)
    {
        return $this->commonDomainId($value);
    }

    public function commonCountryId($value)
    {
        return FilterClauses::linkedId($this->builder, 'common_country_id', \NextDeveloper\Commons\Database\Models\Countries::class, $value);
    }

        //  This is an alias function of commonCountry
    public function common_country_id($value)
    {
        return $this->commonCountryId($value);
    }

    public function iamUserId($value)
    {
        return FilterClauses::linkedId($this->builder, 'iam_user_id', \NextDeveloper\IAM\Database\Models\Users::class, $value);
    }

    //  This is an alias function of iamUserId
    public function iam_user_id($value)
    {
        return $this->iamUserId($value);
    }


    public function iamAccountTypeId($value)
    {
        return FilterClauses::linkedId($this->builder, 'iam_account_type_id', \NextDeveloper\IAM\Database\Models\AccountTypes::class, $value);
    }

        //  This is an alias function of iamAccountType
    public function iam_account_type_id($value)
    {
        return $this->iamAccountTypeId($value);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n



























}
