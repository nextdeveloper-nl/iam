<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\IAM\Database\Observers\LoginLogsObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;
use NextDeveloper\Commons\Common\Cache\Traits\CleanCache;
use NextDeveloper\Commons\Database\Traits\Taggable;

/**
 * Class LoginLogs.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class LoginLogs extends Model
{
    use Filterable, UuidId, CleanCache, Taggable;


    public $timestamps = true;

    protected $table = 'iam_login_logs';


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
    'id'          => 'integer',
    'uuid'        => 'string',
    'created_at'  => 'datetime',
    ];

    /**
     We are casting data fields.
     *
     @var array
     */
    protected $dates = [
    'created_at',
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
        parent::observe(LoginLogsObserver::class);

        self::registerScopes();
    }

    public static function registerScopes()
    {
        $globalScopes = config('iam.scopes.global');
        $modelScopes = config('iam.scopes.iam_login_logs');

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

    public function users() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\NextDeveloper\IAM\Database\Models\Users::class);
    }
    
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n








}
