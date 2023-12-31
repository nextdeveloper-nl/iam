<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\Communication\Database\Traits\SendEmail;
use NextDeveloper\IAM\Database\Observers\AccountsObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;
use NextDeveloper\Commons\Common\Cache\Traits\CleanCache;
use NextDeveloper\Commons\Database\Traits\Taggable;

/**
 * Class Accounts.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class Accounts extends Model
{
    use Filterable, UuidId, CleanCache, Taggable;
    use SoftDeletes;
    use SendEmail;

    public $timestamps = true;

    protected $table = 'iam_accounts';


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
    'id'                  => 'integer',
    'uuid'                => 'string',
    'name'                => 'string',
    'common_domain_id'    => 'integer',
    'common_country_id'   => 'integer',
    'phone_number'        => 'string',
    'description'         => 'string',
    'iam_account_type_id' => 'integer',
    'created_at'          => 'datetime',
    'updated_at'          => 'datetime',
    'deleted_at'          => 'datetime',
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

    public function roleUsers() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\RoleUsers::class);
    }

    public function answers() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\LMS\Database\Models\Answers::class);
    }

    public function courses() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\LMS\Database\Models\Courses::class);
    }

    public function homework() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\LMS\Database\Models\Homework::class);
    }

    public function homeworkAnswers() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\LMS\Database\Models\HomeworkAnswers::class);
    }

    public function questions() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\LMS\Database\Models\Questions::class);
    }

    public function tests() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\LMS\Database\Models\Tests::class);
    }

    public function userTests() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\NextDeveloper\LMS\Database\Models\UserTests::class);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n

    public function users()
    {
        return $this->belongsToMany(Accounts::class, 'iam_account_user', 'iam_account_id', 'iam_user_id');
    }











}
