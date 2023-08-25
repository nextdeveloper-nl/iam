<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\IAM\Database\Observers\IamRolePermissionObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;

/**
* Class IamRolePermission.
*
* @package NextDeveloper\IAM\Database\Models
*/
class IamRolePermission extends Model
{
use Filterable, UuidId;


	public $timestamps = true;

protected $table = 'iam_role_permission';


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
'iam_role_id'       => 'integer',
		'iam_permission_id' => 'integer',
		'is_active'         => 'boolean',
		'created_by'        => 'integer',
		'created_at'        => 'datetime',
		'updated_by'        => 'integer',
		'updated_at'        => 'datetime',
];

/**
* We are casting data fields.
* @var array
*/
protected $dates = [
'created_at',
		'updated_at',
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
parent::observe(IamRolePermissionObserver::class);

self::registerScopes();
}

public static function registerScopes()
{
$globalScopes = config('iam.scopes.global');
$modelScopes = config('iam.scopes.iam_role_permission');

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

public function iamPermission()
    {
        return $this->belongsTo(IamPermission::class);
    }
    
    public function iamRole()
    {
        return $this->belongsTo(IamRole::class);
    }
    
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}