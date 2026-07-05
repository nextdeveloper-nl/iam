<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NextDeveloper\Commons\Common\Cache\Traits\CleanCache;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\Commons\Database\Traits\HasStates;
use NextDeveloper\Commons\Database\Traits\Taggable;
use NextDeveloper\Commons\Database\Traits\UuidId;
use NextDeveloper\IAM\Database\Observers\AccountsObserver;
use Illuminate\Notifications\Notifiable;
use NextDeveloper\Commons\Database\Traits\HasObject;
use NextDeveloper\Commons\Database\Traits\RunAsAdministrator;

/**
 * Accounts model.
 *
 * @package  NextDeveloper\IAM\Database\Models
 * @property integer $id
 * @property string $uuid
 * @property string $name
 * @property integer $common_domain_id
 * @property integer $common_country_id
 * @property string $phone_number
 * @property string $description
 * @property integer $iam_user_id
 * @property integer $iam_account_type_id
 * @property boolean $is_active
 * @property boolean $allow_same_domain_join
 * @property array $tags
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $profile_image_url
 */
class Accounts extends Model
{
    use Filterable, UuidId, CleanCache, Taggable, HasStates, RunAsAdministrator, HasObject;
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'iam_accounts';


    /**
     @var array
     */
    protected $guarded = [];

    protected $fillable = [
            'name',
            'common_domain_id',
            'common_country_id',
            'phone_number',
            'description',
            'iam_user_id',
            'iam_account_type_id',
            'is_active',
            'allow_same_domain_join',
            'tags',
            'profile_image_url',
    ];

    /**
      Here we have the fulltext fields. We can use these for fulltext search if enabled.
     */
    protected $fullTextFields = [

    ];

    /**
     @var array
     */
    protected $appends = [

    ];

    /**
     We are casting fields to objects so that we can work on them better
     *
     @var array
     */
    protected $casts = [
    'id' => 'integer',
    'name' => 'string',
    'common_domain_id' => 'integer',
    'common_country_id' => 'integer',
    'phone_number' => 'string',
    'description' => 'string',
    'iam_account_type_id' => 'integer',
    'is_active' => 'boolean',
    'allow_same_domain_join' => 'boolean',
    'tags' => \NextDeveloper\Commons\Database\Casts\TextArray::class,
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'deleted_at' => 'datetime',
    'profile_image_url' => 'string',
    ];

    /**
     We are casting data fields.
     *
     @var array
     */
    protected $dates = [
    'created_at',
    'updated_at',
    'deleted_at',
    ];

    /**
     @var array
     */
    protected $with = [

    ];

    /**
     @var int
     */
    protected $perPage = 20;

    /**
     @return void
     */
    public static function boot()
    {
        parent::boot();

        //  We create and add Observer even if we wont use it.
        parent::observe(AccountsObserver::class);

        self::registerScopes();
    }

    public static function registerScopes()
    {
        $globalScopes = config('iam.scopes.global');
        $modelScopes = config('iam.scopes.iam_accounts');

        if(!$modelScopes) { $modelScopes = [];
        }
        if (!$globalScopes) { $globalScopes = [];
        }

        $scopes = array_merge(
            $globalScopes,
            $modelScopes
        );

        if($scopes) {
            foreach ($scopes as $scope) {
                static::addGlobalScope(app($scope));
            }
        }
    }

    public function countries() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\NextDeveloper\Commons\Database\Models\Countries::class);
    }
    
    public function domains() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\NextDeveloper\Commons\Database\Models\Domains::class);
    }
    
    public function accountTypes() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\NextDeveloper\IAM\Database\Models\AccountTypes::class);
    }
    
    public function backendDirectories() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\BackendDirectories::class);
    }

    public function accountUsers() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\AccountUsers::class);
    }

    public function roleUsers() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\RoleUsers::class);
    }

    public function sshPublicKeys() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\SshPublicKeys::class);
    }

    public function sshPublicKeyEvents() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\SshPublicKeyEvents::class);
    }

    public function accountStats() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\AccountStats::class);
    }

    public function accounts() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\Accounts::class);
    }

    public function ansiblePlaybookAnsibleRoles() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\AnsiblePlaybookAnsibleRoles::class);
    }

    public function ansiblePlaybooks() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\AnsiblePlaybooks::class);
    }

    public function ansibleRoles() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\AnsibleRoles::class);
    }

    public function ansibleServers() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\AnsibleServers::class);
    }

    public function ansibleSystemPlaybooks() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\AnsibleSystemPlaybooks::class);
    }

    public function ansibleSystemPlaybookExecutions() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\AnsibleSystemPlaybookExecutions::class);
    }

    public function ansibleSystemPlays() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\AnsibleSystemPlays::class);
    }

    public function ansiblePlaybookExecutions() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\AnsiblePlaybookExecutions::class);
    }

    public function computeMemberEvents() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\ComputeMemberEvents::class);
    }

    public function storageVolumes() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\StorageVolumes::class);
    }

    public function computeMemberDevices() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\ComputeMemberDevices::class);
    }

    public function computeMemberNetworkInterfaces() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\ComputeMemberNetworkInterfaces::class);
    }

    public function gateways() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\Gateways::class);
    }

    public function ipAddressHistories() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\IpAddressHistories::class);
    }

    public function networkMemberDevices() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\NetworkMemberDevices::class);
    }

    public function dhcpServers() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\DhcpServers::class);
    }

    public function networkMembers() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\NetworkMembers::class);
    }

    public function storageMemberDevices() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\StorageMemberDevices::class);
    }

    public function repositories() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\Repositories::class);
    }

    public function repositoryImages() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\RepositoryImages::class);
    }

    public function emailAddresses() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\Intelligence\Database\Models\EmailAddresses::class);
    }

    public function mailboxes() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\Intelligence\Database\Models\Mailboxes::class);
    }

    public function channels() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\Communication\Database\Models\Channels::class);
    }

    public function smtpServers() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\Communication\Database\Models\SmtpServers::class);
    }

    public function contacts() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\Communication\Database\Models\Contacts::class);
    }

    public function bots() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\Communication\Database\Models\Bots::class);
    }

    public function threads() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\Communication\Database\Models\Threads::class);
    }

    public function messages() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\Communication\Database\Models\Messages::class);
    }

    public function unsubscribes() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\Communication\Database\Models\Unsubscribes::class);
    }

    public function notifications() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\Communication\Database\Models\Notifications::class);
    }

    public function remindables() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\Communication\Database\Models\Remindables::class);
    }

    public function posts() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\Blogs\Database\Models\Posts::class);
    }

    public function tickets() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\Support\Database\Models\Tickets::class);
    }

    public function ticketComments() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\Support\Database\Models\TicketComments::class);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n

    //    public function users()
    //    {
    //        return $this->belongsToMany(Accounts::class, 'iam_account_user', 'iam_account_id', 'iam_user_id');
    //    }



}
