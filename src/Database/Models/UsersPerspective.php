<?php

namespace NextDeveloper\IAM\Database\Models;

use NextDeveloper\Commons\Database\Traits\HasStates;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\IAM\Database\Observers\UsersPerspectiveObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;
use NextDeveloper\Commons\Common\Cache\Traits\CleanCache;
use NextDeveloper\Commons\Database\Traits\Taggable;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property string $country
 * @property string $language
 * @property string $phone_number
 * @property array $tags
 * @property string $profile_picture
 * @property boolean $is_registered
 * @property integer $iam_account_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class UsersPerspective extends Model
{
    use Filterable, UuidId, CleanCache, Taggable, HasStates;
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
            'country',
            'language',
            'phone_number',
            'tags',
            'profile_picture',
            'is_registered',
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
    'country' => 'string',
    'language' => 'string',
    'phone_number' => 'string',
    'tags' => \NextDeveloper\Commons\Database\Casts\TextArray::class,
    'profile_picture' => 'string',
    'is_registered' => 'boolean',
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
