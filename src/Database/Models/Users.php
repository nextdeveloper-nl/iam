<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\Commons\Database\Traits\HasStates;
use NextDeveloper\Communication\Database\Traits\SendEmail;
use NextDeveloper\Communication\Database\Traits\SendNotification;
use NextDeveloper\Communication\Database\Traits\SendSMS;
use NextDeveloper\IAM\Database\Observers\UsersObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;
use NextDeveloper\Commons\Common\Cache\Traits\CleanCache;
use NextDeveloper\Commons\Database\Traits\Taggable;

/**
 * Users model.
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
 * @property integer $common_language_id
 * @property integer $common_country_id
 * @property string $phone_number
 * @property array $tags
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property integer $profile_picture_identity
 * @property boolean $is_registered
 */
class Users extends Model
{
    use Filterable, UuidId, CleanCache, Taggable, HasStates;
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'iam_users';


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
            'common_language_id',
            'common_country_id',
            'phone_number',
            'tags',
            'profile_picture_identity',
            'is_registered',
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
    'common_language_id' => 'integer',
    'common_country_id' => 'integer',
    'phone_number' => 'string',
    'tags' => \NextDeveloper\Commons\Database\Casts\TextArray::class,
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'deleted_at' => 'datetime',
    'profile_picture_identity' => 'integer',
    'is_registered' => 'boolean',
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
        parent::observe(UsersObserver::class);

        self::registerScopes();
    }

    public static function registerScopes()
    {
        $globalScopes = config('iam.scopes.global');
        $modelScopes = config('iam.scopes.iam_users');

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

    public function accounts() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\Accounts::class);
    }

    public function languages() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\NextDeveloper\Commons\Database\Models\Languages::class);
    }
    
    public function countries() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\NextDeveloper\Commons\Database\Models\Countries::class);
    }
    
    public function loginLogs() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\LoginLogs::class);
    }

    public function accountUsers() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\AccountUsers::class);
    }

    public function loginMechanisms() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\LoginMechanisms::class);
    }

    public function roleUsers() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\RoleUsers::class);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    use Authenticatable;
    use SendEmail;
    use SendNotification;
    use SendSMS;





































}
