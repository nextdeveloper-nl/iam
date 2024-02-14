<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\BackendDirectories;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class BackendDirectoriesTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractBackendDirectoriesTransformer extends AbstractTransformer
{

    /**
     * @param BackendDirectories $model
     *
     * @return array
     */
    public function transform(BackendDirectories $model)
    {
                        $iamAccountId = \NextDeveloper\IAM\Database\Models\Accounts::where('id', $model->iam_account_id)->first();
                    $iaasVirtualMachineId = \NextDeveloper\IAAS\Database\Models\VirtualMachines::where('id', $model->iaas_virtual_machine_id)->first();
        
        return $this->buildPayload(
            [
            'id'  =>  $model->uuid,
            'iam_account_id'  =>  $iamAccountId ? $iamAccountId->uuid : null,
            'iaas_virtual_machine_id'  =>  $iaasVirtualMachineId ? $iaasVirtualMachineId->uuid : null,
            'name'  =>  $model->name,
            'type'  =>  $model->type,
            'ldap_server_name'  =>  $model->ldap_server_name,
            'ldap_server_url'  =>  $model->ldap_server_url,
            'ldap_server_port'  =>  $model->ldap_server_port,
            'ldap_base_dn'  =>  $model->ldap_base_dn,
            'ldap_bind_username'  =>  $model->ldap_bind_username,
            'ldap_bind_password'  =>  $model->ldap_bind_password,
            'default_filter'  =>  $model->default_filter,
            'default_memberof'  =>  $model->default_memberof,
            'default_group'  =>  $model->default_group,
            'default_userid_field'  =>  $model->default_userid_field,
            'default_password_field'  =>  $model->default_password_field,
            'default_email_field'  =>  $model->default_email_field,
            'default_alias_field'  =>  $model->default_alias_field,
            'default_name_field'  =>  $model->default_name_field,
            'default_surname_field'  =>  $model->default_surname_field,
            'is_connected'  =>  $model->is_connected,
            'is_connection_secure'  =>  $model->is_connection_secure,
            'is_usable'  =>  $model->is_usable,
            'created_at'  =>  $model->created_at,
            'updated_at'  =>  $model->updated_at,
            'deleted_at'  =>  $model->deleted_at,
            ]
        );
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE






















}
