<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\IAM\Database\Observers\IamUserObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;

/**
 * Class IamUser.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class IamUser extends Model
{
    use Filterable, UuidId;
    use SoftDeletes;


    public $timestamps = true;

    protected $table = 'iam_users';


    /**
     * @var array
     */
    protected $guarded = [];

    /**
     *  Here we have the fulltext fields. We can use these for fulltext search if enabled.
     */
    protected $fullTextFields = [

    ];

    /**
     * @var array
     */
    protected $appends = [

    ];

    /**
     * We are casting fields to objects so that we can work on them better
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'name' => 'string',
        'surname' => 'string',
        'email' => 'string',
        'fullname' => 'string',
        'username' => 'string',
        'about' => 'string',
        'birthday' => 'datetime',
        'nin' => 'string',
        'cell_phone' => 'string',
        'language_id' => 'integer',
        'country_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * We are casting data fields.
     * @var array
     */
    protected $dates = [
        'birthday',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $with = [

    ];

    /**
     * @var int
     */
    protected $perPage = 20;

    /**
     * @return void
     */
    public static function boot()
    {
        parent::boot();

//  We create and add Observer even if we wont use it.
        parent::observe(IamUserObserver::class);

        self::registerScopes();
    }

    /**
     * @return void
     */
    public static function registerScopes()
    {
        $globalScopes = config('iam.scopes.global');
        $modelScopes = config('iam.scopes.iam_users');

        if (!$modelScopes) $modelScopes = [];
        if (!$globalScopes) $globalScopes = [];

        $scopes = array_merge(
            $globalScopes,
            $modelScopes
        );

        if ($scopes) {
            foreach ($scopes as $scope) {
                static::addGlobalScope(app($scope));
            }
        }
    }

// EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    use Authenticatable, HasApiTokens;

    /**
     * Returns the user account relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function iamAccount()
    {
        return $this->belongsToMany(IamAccount::class, 'iam_account_user', 'user_id', 'account_id');
    }

    /**
     * Returns the user role relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function iamRole()
    {
        return $this->belongsToMany(IamRole::class, 'iam_role_user', 'user_id', 'role_id');
    }
}