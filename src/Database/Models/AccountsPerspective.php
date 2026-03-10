<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Common\Cache\Traits\CleanCache;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\Commons\Database\Traits\HasStates;
use NextDeveloper\Commons\Database\Traits\Taggable;
use NextDeveloper\Commons\Database\Traits\UuidId;
use NextDeveloper\IAM\Database\Observers\AccountsPerspectiveObserver;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use NextDeveloper\Commons\Database\Traits\HasObject;
use NextDeveloper\Commons\Database\Traits\RunAsAdministrator;

/**
 * AccountsPerspective model.
 *
 * @package  NextDeveloper\IAM\Database\Models
 * @property integer $id
 * @property string $uuid
 * @property string $name
 * @property string $description
 * @property string $phone_number
 * @property string $account_owner
 * @property integer $iam_user_id
 * @property string $account_type
 * @property boolean $is_active
 * @property array $tags
 * @property integer $total_user_count
 * @property integer $registered_user_count
 * @property string $domain_name
 * @property integer $common_domain_id
 * @property string $country_name
 * @property string $profile_image_url
 * @property integer $common_country_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class AccountsPerspective extends Model
{
    use Filterable, UuidId, CleanCache, Taggable, HasStates, RunAsAdministrator, HasObject;
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'iam_accounts_perspective';


    /**
     @var array
     */
    protected $guarded = [];

    protected $fillable = [
            'name',
            'description',
            'phone_number',
            'account_owner',
            'iam_user_id',
            'account_type',
            'is_active',
            'tags',
            'total_user_count',
            'registered_user_count',
            'domain_name',
            'common_domain_id',
            'country_name',
            'profile_image_url',
            'common_country_id',
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
    'description' => 'string',
    'phone_number' => 'string',
    'account_owner' => 'string',
    'account_type' => 'string',
    'is_active' => 'boolean',
    'tags' => \NextDeveloper\Commons\Database\Casts\TextArray::class,
    'total_user_count' => 'integer',
    'registered_user_count' => 'integer',
    'domain_name' => 'string',
    'common_domain_id' => 'integer',
    'country_name' => 'string',
    'profile_image_url' => 'string',
    'common_country_id' => 'integer',
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
        parent::observe(AccountsPerspectiveObserver::class);

        self::registerScopes();
    }

    public static function registerScopes()
    {
        $globalScopes = config('iam.scopes.global');
        $modelScopes = config('iam.scopes.iam_accounts_perspective');

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
