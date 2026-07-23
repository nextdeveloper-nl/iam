<?php

namespace NextDeveloper\IAM\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;
        

/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class SshPublicKeysQueryFilter extends AbstractQueryFilter
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


    public function publicKey($value)
    {
        return $this->builder->where('public_key', 'ilike', '%' . $value . '%');
    }

        //  This is an alias function of publicKey
    public function public_key($value)
    {
        return $this->publicKey($value);
    }

    public function fingerprint($value)
    {
        return $this->builder->where('fingerprint', 'ilike', '%' . $value . '%');
    }


    public function keyType($value)
    {
        return $this->builder->where('key_type', 'ilike', '%' . $value . '%');
    }

        //  This is an alias function of keyType
    public function key_type($value)
    {
        return $this->keyType($value);
    }

    public function scope($value)
    {
        return $this->builder->where('scope', 'ilike', '%' . $value . '%');
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

    public function expiresAtStart($date)
    {
        return $this->builder->where('expires_at', '>=', $date);
    }

    public function expiresAtEnd($date)
    {
        return $this->builder->where('expires_at', '<=', $date);
    }

    //  This is an alias function of expiresAt
    public function expires_at_start($value)
    {
        return $this->expiresAtStart($value);
    }

    //  This is an alias function of expiresAt
    public function expires_at_end($value)
    {
        return $this->expiresAtEnd($value);
    }

    public function lastUsedAtStart($date)
    {
        return $this->builder->where('last_used_at', '>=', $date);
    }

    public function lastUsedAtEnd($date)
    {
        return $this->builder->where('last_used_at', '<=', $date);
    }

    //  This is an alias function of lastUsedAt
    public function last_used_at_start($value)
    {
        return $this->lastUsedAtStart($value);
    }

    //  This is an alias function of lastUsedAt
    public function last_used_at_end($value)
    {
        return $this->lastUsedAtEnd($value);
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

    public function iamAccountId($value)
    {
            $iamAccount = \NextDeveloper\IAM\Database\Models\Accounts::where('uuid', $value)->first();

        if($iamAccount) {
            return $this->builder->where('iam_account_id', '=', $iamAccount->id);
        }
    }


    public function iamUserId($value)
    {
            $iamUser = \NextDeveloper\IAM\Database\Models\Users::where('uuid', $value)->first();

        if($iamUser) {
            return $this->builder->where('iam_user_id', '=', $iamUser->id);
        }
    }


    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
