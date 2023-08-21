<?php

namespace NextDeveloper\IAM\Http\Requests\IamBackend;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class IamBackendUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules() {
        return [
            'iam_account_id'           => 'nullable|exists:iam_accounts,uuid|uuid',
			'iaas_virtual_machine_id'  => 'nullable|exists:iaas_virtual_machines,uuid|uuid',
			'name'                     => 'nullable|string|max:100',
			'type'                     => '',
			'ldap_server_name'         => 'nullable|string|max:250',
			'ldap_server_url'          => 'nullable|string|max:250',
			'ldap_server_port'         => 'nullable|string|max:250',
			'ldap_base_dn'             => 'nullable|string|max:250',
			'ldap_bind_username'       => 'nullable|string|max:250',
			'ldap_bind_password'       => 'nullable|string|max:250',
			'default_filter'           => 'string|max:100',
			'default_memberof'         => 'nullable|string|max:100',
			'default_group'            => 'nullable|string|max:100',
			'default_userid_field'     => 'string|max:100',
			'default_password_field'   => 'string|max:100',
			'default_email_field'      => 'string|max:100',
			'default_alias_field'      => 'string|max:100',
			'default_first_name_field' => 'string|max:100',
			'default_last_name_field'  => 'string|max:100',
			'is_connected'             => 'boolean',
			'is_connection_secure'     => 'boolean',
			'is_usable'                => 'boolean',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}