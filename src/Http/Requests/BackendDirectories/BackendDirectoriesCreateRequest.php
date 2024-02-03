<?php

namespace NextDeveloper\IAM\Http\Requests\BackendDirectories;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class BackendDirectoriesCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'iaas_virtual_machine_id' => 'nullable|exists:iaas_virtual_machines,uuid|uuid',
        'name' => 'required|string',
        'type' => '',
        'ldap_server_name' => 'nullable',
        'ldap_server_url' => 'nullable',
        'ldap_server_port' => 'nullable',
        'ldap_base_dn' => 'nullable',
        'ldap_bind_username' => 'nullable',
        'ldap_bind_password' => 'nullable',
        'default_filter' => 'string',
        'default_memberof' => 'nullable|string',
        'default_group' => 'nullable|string',
        'default_userid_field' => 'string',
        'default_password_field' => 'string',
        'default_email_field' => 'string',
        'default_alias_field' => 'string',
        'default_name_field' => 'string',
        'default_surname_field' => 'string',
        'is_connected' => 'boolean',
        'is_connection_secure' => 'boolean',
        'is_usable' => 'boolean',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}