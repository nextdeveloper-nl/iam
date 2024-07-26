<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\Commons\Database\Models\Addresses;
use NextDeveloper\Commons\Database\Models\Comments;
use NextDeveloper\Commons\Database\Models\Meta;
use NextDeveloper\Commons\Database\Models\PhoneNumbers;
use NextDeveloper\Commons\Database\Models\SocialMedia;
use NextDeveloper\Commons\Database\Models\Votes;
use NextDeveloper\Commons\Database\Models\Media;
use NextDeveloper\Commons\Http\Transformers\MediaTransformer;
use NextDeveloper\Commons\Database\Models\AvailableActions;
use NextDeveloper\Commons\Http\Transformers\AvailableActionsTransformer;
use NextDeveloper\Commons\Database\Models\States;
use NextDeveloper\Commons\Http\Transformers\StatesTransformer;
use NextDeveloper\Commons\Http\Transformers\CommentsTransformer;
use NextDeveloper\Commons\Http\Transformers\SocialMediaTransformer;
use NextDeveloper\Commons\Http\Transformers\MetaTransformer;
use NextDeveloper\Commons\Http\Transformers\VotesTransformer;
use NextDeveloper\Commons\Http\Transformers\AddressesTransformer;
use NextDeveloper\Commons\Http\Transformers\PhoneNumbersTransformer;
use NextDeveloper\IAM\Database\Models\BackendDirectories;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;

/**
 * Class BackendDirectoriesTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractBackendDirectoriesTransformer extends AbstractTransformer
{

    /**
     * @var array
     */
    protected array $availableIncludes = [
        'states',
        'actions',
        'media',
        'comments',
        'votes',
        'socialMedia',
        'phoneNumbers',
        'addresses',
        'meta'
    ];

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
            'iam_backend_types'  =>  $model->iam_backend_types,
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

    public function includeStates(BackendDirectories $model)
    {
        $states = States::where('object_type', get_class($model))
            ->where('object_id', $model->id)
            ->get();

        return $this->collection($states, new StatesTransformer());
    }

    public function includeActions(BackendDirectories $model)
    {
        $input = get_class($model);
        $input = str_replace('\\Database\\Models', '', $input);

        $actions = AvailableActions::withoutGlobalScope(AuthorizationScope::class)
            ->where('input', $input)
            ->get();

        return $this->collection($actions, new AvailableActionsTransformer());
    }

    public function includeMedia(BackendDirectories $model)
    {
        $media = Media::where('object_type', get_class($model))
            ->where('object_id', $model->id)
            ->get();

        return $this->collection($media, new MediaTransformer());
    }

    public function includeSocialMedia(BackendDirectories $model)
    {
        $socialMedia = SocialMedia::where('object_type', get_class($model))
            ->where('object_id', $model->id)
            ->get();

        return $this->collection($socialMedia, new SocialMediaTransformer());
    }

    public function includeComments(BackendDirectories $model)
    {
        $comments = Comments::where('object_type', get_class($model))
            ->where('object_id', $model->id)
            ->get();

        return $this->collection($comments, new CommentsTransformer());
    }

    public function includeVotes(BackendDirectories $model)
    {
        $votes = Votes::where('object_type', get_class($model))
            ->where('object_id', $model->id)
            ->get();

        return $this->collection($votes, new VotesTransformer());
    }

    public function includeMeta(BackendDirectories $model)
    {
        $meta = Meta::where('object_type', get_class($model))
            ->where('object_id', $model->id)
            ->get();

        return $this->collection($meta, new MetaTransformer());
    }

    public function includePhoneNumbers(BackendDirectories $model)
    {
        $phoneNumbers = PhoneNumbers::where('object_type', get_class($model))
            ->where('object_id', $model->id)
            ->get();

        return $this->collection($phoneNumbers, new PhoneNumbersTransformer());
    }

    public function includeAddresses(BackendDirectories $model)
    {
        $addresses = Addresses::where('object_type', get_class($model))
            ->where('object_id', $model->id)
            ->get();

        return $this->collection($addresses, new AddressesTransformer());
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
