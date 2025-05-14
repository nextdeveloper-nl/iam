<?php

namespace NextDeveloper\IAM\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;


/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class UsersPerspectiveQueryFilter extends AbstractQueryFilter
{
    /**
     * Filter by tags
     *
     * @param  $values
     * @return Builder
     */
    public function tags($values)
    {
        $tags = explode(',', $values);

        $search = '';

        for($i = 0; $i < count($tags); $i++) {
            $search .= "'" . trim($tags[$i]) . "',";
        }

        $search = substr($search, 0, -1);

        return $this->builder->whereRaw('tags @> ARRAY[' . $search . ']');
    }

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

    public function country($value)
    {
        return $this->builder->where('country', 'ilike', '%' . $value . '%');
    }

    public function language($value)
    {
        return $this->builder->where('language', 'ilike', '%' . $value . '%');
    }

    public function phoneNumber($value)
    {
        return $this->builder->where('phone_number', 'ilike', '%' . $value . '%');
    }

    public function profilePicture($value)
    {
        return $this->builder->where('profile_picture', 'ilike', '%' . $value . '%');
    }

    public function isRegistered($value)
    {


        return $this->builder->where('is_registered', $value);
    }

    public function isActive($value)
    {


        return $this->builder->where('is_active', $value);
    }

    public function birthdayStart($date)
    {
        return $this->builder->where('birthday', '>=', $date);
    }

    public function birthdayEnd($date)
    {
        return $this->builder->where('birthday', '<=', $date);
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

    public function iamAccountId($value)
    {
            $iamAccount = \NextDeveloper\IAM\Database\Models\Accounts::where('uuid', $value)->first();

        if($iamAccount) {
            return $this->builder->where('iam_account_id', '=', $iamAccount->id);
        }
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE



}
