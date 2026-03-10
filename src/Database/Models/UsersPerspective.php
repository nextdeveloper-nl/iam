<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NextDeveloper\Commons\Common\Cache\Traits\CleanCache;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\Commons\Database\Traits\HasStates;
use NextDeveloper\Commons\Database\Traits\Taggable;
use NextDeveloper\Commons\Database\Traits\UuidId;
use NextDeveloper\IAM\Database\Observers\UsersPerspectiveObserver;
use Illuminate\Notifications\Notifiable;
use NextDeveloper\Commons\Database\Traits\HasObject;
use NextDeveloper\Commons\Database\Traits\RunAsAdministrator;

/**
 * UsersPerspective model.
 *
 * @package  NextDeveloper\IAM\Database\Models
 * @property integer $id
 * @property string $uuid
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $fullname
 * @property string $username
 * @property string $about
 * @property string $pronoun
 * @property \Carbon\Carbon $birthday
 * @property string $nin
 * @property integer $common_country_id
 * @property string $country
 * @property integer $common_language_id
 * @property string $language
 * @property string $phone_number
 * @property array $tags
 * @property array $roles
 * @property string $profile_picture
 * @property boolean $has_valid_google_login
 * @property boolean $is_registered
 * @property boolean $is_active
 * @property boolean $is_nin_verified
 * @property boolean $is_email_verified
 * @property boolean $is_phone_number_verified
 * @property boolean $is_profile_verified
 * @property integer $iam_account_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class UsersPerspective extends Model
{
    use Filterable, UuidId, CleanCache, Taggable, HasStates, RunAsAdministrator, HasObject;
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'iam_users_perspective';


    /**
     @var array
     */
    protected $guarded = [];

    protected $fillable = [
            'name',
            'surname',
            'email',
            'fullname',
            'username',
            'about',
            'pronoun',
            'birthday',
            'nin',
            'common_country_id',
            'country',
            'common_language_id',
            'language',
            'phone_number',
            'tags',
            'roles',
            'profile_picture',
            'has_valid_google_login',
            'is_registered',
            'is_active',
            'is_nin_verified',
            'is_email_verified',
            'is_phone_number_verified',
            'is_profile_verified',
            'iam_account_id',
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
    'surname' => 'string',
    'email' => 'string',
    'fullname' => 'string',
    'username' => 'string',
    'about' => 'string',
    'pronoun' => 'string',
    'birthday' => 'datetime',
    'nin' => 'string',
    'common_country_id' => 'integer',
    'country' => 'string',
    'common_language_id' => 'integer',
    'language' => 'string',
    'phone_number' => 'string',
    'tags' => \NextDeveloper\Commons\Database\Casts\TextArray::class,
    'roles' => \NextDeveloper\Commons\Database\Casts\TextArray::class,
    'profile_picture' => 'string',
    'has_valid_google_login' => 'boolean',
    'is_registered' => 'boolean',
    'is_active' => 'boolean',
    'is_nin_verified' => 'boolean',
    'is_email_verified' => 'boolean',
    'is_phone_number_verified' => 'boolean',
    'is_profile_verified' => 'boolean',
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
    'birthday',
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
        parent::observe(UsersPerspectiveObserver::class);

        self::registerScopes();
    }

    public static function registerScopes()
    {
        $globalScopes = config('iam.scopes.global');
        $modelScopes = config('iam.scopes.iam_users_perspective');

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
