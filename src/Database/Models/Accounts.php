<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\IAM\Database\Observers\AccountsObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;

/**
* Class Accounts.
*
* @package NextDeveloper\IAM\Database\Models
*/
class Accounts extends Model
{
use Filterable, UuidId;
	use SoftDeletes;


	public $timestamps = true;

protected $table = 'iam_accounts';


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
'id'                  => 'integer',
		'uuid'                => 'string',
		'name'                => 'string',
		'common_domain_id'    => 'integer',
		'common_country_id'   => 'integer',
		'phone_number'        => 'string',
		'description'         => 'string',
		'iam_user_id'         => 'integer',
		'iam_account_type_id' => 'integer',
		'created_at'          => 'datetime',
		'updated_at'          => 'datetime',
		'deleted_at'          => 'datetime',
];

/**
* We are casting data fields.
* @var array
*/
protected $dates = [
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
parent::observe(AccountsObserver::class);

self::registerScopes();
}

public static function registerScopes()
{
$globalScopes = config('iam.scopes.global');
$modelScopes = config('iam.scopes.iam_accounts');

if(!$modelScopes) $modelScopes = [];
if (!$globalScopes) $globalScopes = [];

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

public function Domains()
    {
        return $this->belongsTo(\NextDeveloper\Commons\Database\Models\Domains::class);
    }
    
    public function AccountTypes()
    {
        return $this->belongsTo(\NextDeveloper\IAM\Database\Models\AccountTypes::class);
    }
    
    public function Backends()
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\Backends::class);
    }

    public function RoleUsers()
    {
        return $this->hasMany(\NextDeveloper\IAM\Database\Models\RoleUsers::class);
    }

    public function Products()
    {
        return $this->hasMany(\NextDeveloper\Marketplace\Database\Models\Products::class);
    }

    public function Accounts()
    {
        return $this->hasMany(\NextDeveloper\CRM\Database\Models\Accounts::class);
    }

    public function Opportunities()
    {
        return $this->hasMany(\NextDeveloper\CRM\Database\Models\Opportunities::class);
    }

    public function cloudNodes()
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\CloudNodes::class);
    }

    public function datacenters()
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\Datacenters::class);
    }

    public function networkPools()
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\NetworkPools::class);
    }

    public function storagePools()
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\StoragePools::class);
    }

    public function computeMembers()
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\ComputeMembers::class);
    }

    public function computePools()
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\ComputePools::class);
    }

    public function virtualMachines()
    {
        return $this->hasMany(\NextDeveloper\IAAS\Database\Models\VirtualMachines::class);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n

    public function Users()
    {
        return $this->belongsToMany(Accounts::class, 'iam_account_user', 'iam_account_id', 'iam_user_id');
    }

}