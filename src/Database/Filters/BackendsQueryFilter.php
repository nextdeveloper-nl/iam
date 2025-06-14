<?php

namespace NextDeveloper\IAM\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;


/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class BackendsQueryFilter extends AbstractQueryFilter
{
    /**
     * @var Builder
     */
    protected $builder;

    public function name($value)
    {
        return $this->builder->where('name', 'ilike', '%' . $value . '%');
    }

    public function ldapServerName($value)
    {
        return $this->builder->where('ldap_server_name', 'ilike', '%' . $value . '%');
    }

    public function ldapServerUrl($value)
    {
        return $this->builder->where('ldap_server_url', 'ilike', '%' . $value . '%');
    }

    public function ldapServerPort($value)
    {
        return $this->builder->where('ldap_server_port', 'ilike', '%' . $value . '%');
    }

    public function ldapBaseDn($value)
    {
        return $this->builder->where('ldap_base_dn', 'ilike', '%' . $value . '%');
    }

    public function ldapBindUsername($value)
    {
        return $this->builder->where('ldap_bind_username', 'ilike', '%' . $value . '%');
    }

    public function ldapBindPassword($value)
    {
        return $this->builder->where('ldap_bind_password', 'ilike', '%' . $value . '%');
    }

    public function defaultFilter($value)
    {
        return $this->builder->where('default_filter', 'ilike', '%' . $value . '%');
    }

    public function defaultMemberof($value)
    {
        return $this->builder->where('default_memberof', 'ilike', '%' . $value . '%');
    }

    public function defaultGroup($value)
    {
        return $this->builder->where('default_group', 'ilike', '%' . $value . '%');
    }

    public function defaultUseridField($value)
    {
        return $this->builder->where('default_userid_field', 'ilike', '%' . $value . '%');
    }

    public function defaultPasswordField($value)
    {
        return $this->builder->where('default_password_field', 'ilike', '%' . $value . '%');
    }

    public function defaultEmailField($value)
    {
        return $this->builder->where('default_email_field', 'ilike', '%' . $value . '%');
    }

    public function defaultAliasField($value)
    {
        return $this->builder->where('default_alias_field', 'ilike', '%' . $value . '%');
    }

    public function defaultFirstNameField($value)
    {
        return $this->builder->where('default_first_name_field', 'ilike', '%' . $value . '%');
    }

    public function defaultLastNameField($value)
    {
        return $this->builder->where('default_last_name_field', 'ilike', '%' . $value . '%');
    }

    public function isConnected()
    {
        return $this->builder->where('is_connected', true);
    }

    public function isConnectionSecure()
    {
        return $this->builder->where('is_connection_secure', true);
    }

    public function isUsable()
    {
        return $this->builder->where('is_usable', true);
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

    public function iaasVirtualMachineId($value)
    {
            $iaasVirtualMachine = \NextDeveloper\IAAS\Database\Models\VirtualMachines::where('uuid', $value)->first();

        if($iaasVirtualMachine) {
            return $this->builder->where('iaas_virtual_machine_id', '=', $iaasVirtualMachine->id);
        }
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}
