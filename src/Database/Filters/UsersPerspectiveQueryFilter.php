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
        return $this->builder->where('name', 'like', '%' . $value . '%');
    }
    
    public function surname($value)
    {
        return $this->builder->where('surname', 'like', '%' . $value . '%');
    }
    
    public function email($value)
    {
        return $this->builder->where('email', 'like', '%' . $value . '%');
    }
    
    public function fullname($value)
    {
        return $this->builder->where('fullname', 'like', '%' . $value . '%');
    }
    
    public function username($value)
    {
        return $this->builder->where('username', 'like', '%' . $value . '%');
    }
    
    public function about($value)
    {
        return $this->builder->where('about', 'like', '%' . $value . '%');
    }
    
    public function pronoun($value)
    {
        return $this->builder->where('pronoun', 'like', '%' . $value . '%');
    }
    
    public function nin($value)
    {
        return $this->builder->where('nin', 'like', '%' . $value . '%');
    }
    
    public function country($value)
    {
        return $this->builder->where('country', 'like', '%' . $value . '%');
    }
    
    public function language($value)
    {
        return $this->builder->where('language', 'like', '%' . $value . '%');
    }
    
    public function phoneNumber($value)
    {
        return $this->builder->where('phone_number', 'like', '%' . $value . '%');
    }
    
    public function profilePicture($value)
    {
        return $this->builder->where('profile_picture', 'like', '%' . $value . '%');
    }

    public function isRegistered($value)
    {
        if(!is_bool($value)) {
            $value = false;
        }

        return $this->builder->where('is_registered', $value);
    }

    public function birthdayStart($date)
    {
        return $this->builder->where('birthday', '>=', $date);
    }

    public function birthdayEnd($date)
    {
        return $this->builder->where('birthday', '<=', $date);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
