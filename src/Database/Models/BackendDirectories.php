<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\IAM\Database\Observers\BackendDirectoriesObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;
use NextDeveloper\Commons\Common\Cache\Traits\CleanCache;
use NextDeveloper\Commons\Database\Traits\Taggable;

/**
 * Class BackendDirectories.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class BackendDirectories extends Model
{
    use Filterable, UuidId, CleanCache, Taggable;
    use SoftDeletes;


    public $timestamps = true;

    protected $table = 'iam_backend_directories';


    /**
     @var array
     */
    protected $guarded = [];

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
    'id'                       => 'integer',
    'uuid'                     => 'string',
    'iaas_virtual_machine_id'  => 'integer',
    'name'                     => 'string',
    'ldap_server_name'         => 'string',
    'ldap_server_url'          => 'string',
    'ldap_server_port'         => 'string',
    'ldap_base_dn'             => 'string',
    'ldap_bind_username'       => 'string',
    'ldap_bind_password'       => 'string',
    'default_filter'           => 'string',
    'default_memberof'         => 'string',
    'default_group'            => 'string',
    'default_userid_field'     => 'string',
    'default_password_field'   => 'string',
    'default_email_field'      => 'string',
    'default_alias_field'      => 'string',
    'default_first_name_field' => 'string',
    'default_last_name_field'  => 'string',
    'is_connected'             => 'boolean',
    'is_connection_secure'     => 'boolean',
    'is_usable'                => 'boolean',
    'created_at'               => 'datetime',
    'updated_at'               => 'datetime',
    'deleted_at'               => 'datetime',
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
        parent::observe(BackendDirectoriesObserver::class);

        self::registerScopes();
    }

    public static function registerScopes()
    {
        $globalScopes = config('iam.scopes.global');
        $modelScopes = config('iam.scopes.iam_backend_directories');

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

    public function accounts() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\NextDeveloper\IAM\Database\Models\Accounts::class);
    }
    
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
