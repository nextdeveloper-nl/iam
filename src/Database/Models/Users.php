<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\IAM\Database\Observers\UsersObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;

/**
 * Class Users.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class Users extends Model
{
    use Filterable, UuidId;
    use SoftDeletes;


    public $timestamps = true;

    protected $table = 'iam_users';


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
    'id'                 => 'integer',
    'uuid'               => 'string',
    'name'               => 'string',
    'surname'            => 'string',
    'email'              => 'string',
    'fullname'           => 'string',
    'username'           => 'string',
    'about'              => 'string',
    'pronoun'            => 'string',
    'birthday'           => 'datetime',
    'nin'                => 'string',
    'cell_phone'         => 'string',
    'common_language_id' => 'integer',
    'common_country_id'  => 'integer',
    'created_at'         => 'datetime',
    'updated_at'         => 'datetime',
    'deleted_at'         => 'datetime',
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

    public function accountUsers()
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\AccountUsers::class);
    }

    public function loginLogs()
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\LoginLogs::class);
    }

    public function loginMechanisms()
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\LoginMechanisms::class);
    }

    public function roleUsers()
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\RoleUsers::class);
    }

    public function countries()
    {
        return $this->belongsTo(\NextDeveloper\Commons\Database\Models\Countries::class);
    }
    
    public function languages()
    {
        return $this->belongsTo(\NextDeveloper\Commons\Database\Models\Languages::class);
    }
    
    public function products()
    {
        return $this->hasMany(\NextDeveloper\Marketplace\Database\Models\Products::class);
    }

    public function users()
    {
        return $this->hasMany(\NextDeveloper\CRM\Database\Models\Users::class);
    }

    public function cloudNodes()
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\CloudNodes::class);
    }

    public function computeMembers()
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\ComputeMembers::class);
    }

    public function computePools()
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\ComputePools::class);
    }

    public function networkPools()
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\NetworkPools::class);
    }

    public function storagePools()
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\StoragePools::class);
    }

    public function virtualMachines()
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\VirtualMachines::class);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n


    use Authenticatable, HasApiTokens;

    /**
     * Returns the user account relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function iamAccount()
    {
        return $this->belongsToMany(IamAccount::class, 'iam_account_user', 'iam_user_id', 'iam_account_id');
    }

    /**
     * Returns the user role relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function iamRole()
    {
        return $this->belongsToMany(IamRole::class, 'iam_role_user', 'iam_user_id', 'iam_role_id', 'id');
    }
}