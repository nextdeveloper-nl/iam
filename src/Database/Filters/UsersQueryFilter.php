<?php

namespace NextDeveloper\IAM\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;
        

/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class UsersQueryFilter extends AbstractQueryFilter
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


    public function phoneNumber($value)
    {
        return $this->builder->where('phone_number', 'ilike', '%' . $value . '%');
    }

        //  This is an alias function of phoneNumber
    public function phone_number($value)
    {
        return $this->phoneNumber($value);
    }

    public function profilePictureIdentity($value)
    {
        $operator = substr($value, 0, 1);

        if ($operator != '<' || $operator != '>') {
            $operator = '=';
        } else {
            $value = substr($value, 1);
        }

        return $this->builder->where('profile_picture_identity', $operator, $value);
    }

        //  This is an alias function of profilePictureIdentity
    public function profile_picture_identity($value)
    {
        return $this->profilePictureIdentity($value);
    }

    public function isRegistered($value)
    {
        return $this->builder->where('is_registered', $value);
    }

        //  This is an alias function of isRegistered
    public function is_registered($value)
    {
        return $this->isRegistered($value);
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

    public function isNinVerified($value)
    {
        return $this->builder->where('is_nin_verified', $value);
    }

        //  This is an alias function of isNinVerified
    public function is_nin_verified($value)
    {
        return $this->isNinVerified($value);
    }

    public function isEmailVerified($value)
    {
        return $this->builder->where('is_email_verified', $value);
    }

        //  This is an alias function of isEmailVerified
    public function is_email_verified($value)
    {
        return $this->isEmailVerified($value);
    }

    public function isPhoneNumberVerified($value)
    {
        return $this->builder->where('is_phone_number_verified', $value);
    }

        //  This is an alias function of isPhoneNumberVerified
    public function is_phone_number_verified($value)
    {
        return $this->isPhoneNumberVerified($value);
    }

    public function isProfileVerified($value)
    {
        return $this->builder->where('is_profile_verified', $value);
    }

        //  This is an alias function of isProfileVerified
    public function is_profile_verified($value)
    {
        return $this->isProfileVerified($value);
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

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n



























}
