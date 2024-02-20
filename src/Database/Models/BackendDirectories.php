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
 * BackendDirectories model.
 *
 * @package  NextDeveloper\IAM\Database\Models
 * @property integer $id
 * @property string $uuid
 * @property integer $iam_account_id
 * @property integer $iaas_virtual_machine_id
 * @property string $name
 * @property $type
 * @property $ldap_server_name
 * @property $ldap_server_url
 * @property $ldap_server_port
 * @property $ldap_base_dn
 * @property $ldap_bind_username
 * @property $ldap_bind_password
 * @property string $default_filter
 * @property string $default_memberof
 * @property string $default_group
 * @property string $default_userid_field
 * @property string $default_password_field
 * @property string $default_email_field
 * @property string $default_alias_field
 * @property string $default_name_field
 * @property string $default_surname_field
 * @property boolean $is_connected
 * @property boolean $is_connection_secure
 * @property boolean $is_usable
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
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

    protected $fillable = [
            'iam_account_id',
            'iaas_virtual_machine_id',
            'name',
            'type',
            'ldap_server_name',
            'ldap_server_url',
            'ldap_server_port',
            'ldap_base_dn',
            'ldap_bind_username',
            'ldap_bind_password',
            'default_filter',
            'default_memberof',
            'default_group',
            'default_userid_field',
            'default_password_field',
            'default_email_field',
            'default_alias_field',
            'default_name_field',
            'default_surname_field',
            'is_connected',
            'is_connection_secure',
            'is_usable',
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
    'iaas_virtual_machine_id' => 'integer',
    'name' => 'string',
    'default_filter' => 'string',
    'default_memberof' => 'string',
    'default_group' => 'string',
    'default_userid_field' => 'string',
    'default_password_field' => 'string',
    'default_email_field' => 'string',
    'default_alias_field' => 'string',
    'default_name_field' => 'string',
    'default_surname_field' => 'string',
    'is_connected' => 'boolean',
    'is_connection_secure' => 'boolean',
    'is_usable' => 'boolean',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'deleted_at' => 'datetime',
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

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
























}
