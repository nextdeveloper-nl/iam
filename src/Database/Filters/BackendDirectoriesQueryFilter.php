<?php

namespace NextDeveloper\IAM\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;
        

/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class BackendDirectoriesQueryFilter extends AbstractQueryFilter
{

    /**
     * @var Builder
     */
    protected $builder;
    
    public function name($value)
    {
        return $this->builder->where('name', 'ilike', '%' . $value . '%');
    }

        
    public function defaultFilter($value)
    {
        return $this->builder->where('default_filter', 'ilike', '%' . $value . '%');
    }

        //  This is an alias function of defaultFilter
    public function default_filter($value)
    {
        return $this->defaultFilter($value);
    }
        
    public function defaultMemberof($value)
    {
        return $this->builder->where('default_memberof', 'ilike', '%' . $value . '%');
    }

        //  This is an alias function of defaultMemberof
    public function default_memberof($value)
    {
        return $this->defaultMemberof($value);
    }
        
    public function defaultGroup($value)
    {
        return $this->builder->where('default_group', 'ilike', '%' . $value . '%');
    }

        //  This is an alias function of defaultGroup
    public function default_group($value)
    {
        return $this->defaultGroup($value);
    }
        
    public function defaultUseridField($value)
    {
        return $this->builder->where('default_userid_field', 'ilike', '%' . $value . '%');
    }

        //  This is an alias function of defaultUseridField
    public function default_userid_field($value)
    {
        return $this->defaultUseridField($value);
    }
        
    public function defaultPasswordField($value)
    {
        return $this->builder->where('default_password_field', 'ilike', '%' . $value . '%');
    }

        //  This is an alias function of defaultPasswordField
    public function default_password_field($value)
    {
        return $this->defaultPasswordField($value);
    }
        
    public function defaultEmailField($value)
    {
        return $this->builder->where('default_email_field', 'ilike', '%' . $value . '%');
    }

        //  This is an alias function of defaultEmailField
    public function default_email_field($value)
    {
        return $this->defaultEmailField($value);
    }
        
    public function defaultAliasField($value)
    {
        return $this->builder->where('default_alias_field', 'ilike', '%' . $value . '%');
    }

        //  This is an alias function of defaultAliasField
    public function default_alias_field($value)
    {
        return $this->defaultAliasField($value);
    }
        
    public function defaultNameField($value)
    {
        return $this->builder->where('default_name_field', 'ilike', '%' . $value . '%');
    }

        //  This is an alias function of defaultNameField
    public function default_name_field($value)
    {
        return $this->defaultNameField($value);
    }
        
    public function defaultSurnameField($value)
    {
        return $this->builder->where('default_surname_field', 'ilike', '%' . $value . '%');
    }

        //  This is an alias function of defaultSurnameField
    public function default_surname_field($value)
    {
        return $this->defaultSurnameField($value);
    }
    
    public function isConnected($value)
    {
        return $this->builder->where('is_connected', $value);
    }

        //  This is an alias function of isConnected
    public function is_connected($value)
    {
        return $this->isConnected($value);
    }
     
    public function isConnectionSecure($value)
    {
        return $this->builder->where('is_connection_secure', $value);
    }

        //  This is an alias function of isConnectionSecure
    public function is_connection_secure($value)
    {
        return $this->isConnectionSecure($value);
    }
     
    public function isUsable($value)
    {
        return $this->builder->where('is_usable', $value);
    }

        //  This is an alias function of isUsable
    public function is_usable($value)
    {
        return $this->isUsable($value);
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

    
    public function iaasVirtualMachineId($value)
    {
            $iaasVirtualMachine = \NextDeveloper\IAAS\Database\Models\VirtualMachines::where('uuid', $value)->first();

        if($iaasVirtualMachine) {
            return $this->builder->where('iaas_virtual_machine_id', '=', $iaasVirtualMachine->id);
        }
    }

        //  This is an alias function of iaasVirtualMachine
    public function iaas_virtual_machine_id($value)
    {
        return $this->iaasVirtualMachine($value);
    }
    
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE



























}
