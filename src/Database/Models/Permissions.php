<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Common\Cache\Traits\CleanCache;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\Commons\Database\Traits\HasStates;
use NextDeveloper\Commons\Database\Traits\Taggable;
use NextDeveloper\Commons\Database\Traits\UuidId;
use NextDeveloper\IAM\Database\Observers\PermissionsObserver;

/**
 * Permissions model.
 *
 * @package  NextDeveloper\IAM\Database\Models
 * @property integer $id
 * @property string $uuid
 * @property string $namespace
 * @property string $service
 * @property string $method
 * @property string $name
 * @property boolean $is_active
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Permissions extends Model
{
    use Filterable, UuidId, CleanCache, Taggable, HasStates;

    public $timestamps = true;

    protected $table = 'iam_permissions';


    /**
     @var array
     */
    protected $guarded = [];

    protected $fillable = [
            'namespace',
            'service',
            'method',
            'name',
            'is_active',
            'created_by',
            'updated_by',
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
    'namespace' => 'string',
    'service' => 'string',
    'method' => 'string',
    'name' => 'string',
    'is_active' => 'boolean',
    'created_by' => 'integer',
    'updated_by' => 'integer',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    ];

    /**
     We are casting data fields.
     *
     @var array
     */
    protected $dates = [
    'created_at',
    'updated_at',
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
        parent::observe(PermissionsObserver::class);

        self::registerScopes();
    }

    public static function registerScopes()
    {
        $globalScopes = config('iam.scopes.global');
        $modelScopes = config('iam.scopes.iam_permissions');

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

    public function rolePermissions() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\RolePermissions::class);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n



























































}
