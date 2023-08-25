<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\IAM\Database\Observers\IamRoleUserObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;

/**
* Class IamRoleUser.
*
* @package NextDeveloper\IAM\Database\Models
*/
class IamRoleUser extends Model
{
use Filterable, UuidId;


	public $timestamps = false;

protected $table = 'iam_role_user';


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
'iam_role_id'    => 'integer',
		'iam_user_id'    => 'integer',
		'iam_account_id' => 'integer',
		'is_active'      => 'boolean',
];

/**
* We are casting data fields.
* @var array
*/
protected $dates = [

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
parent::observe(IamRoleUserObserver::class);

self::registerScopes();
}

public static function registerScopes()
{
$globalScopes = config('iam.scopes.global');
$modelScopes = config('iam.scopes.iam_role_user');

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

public function iamAccount()
    {
        return $this->belongsTo(IamAccount::class);
    }
    
    public function iamRole()
    {
        return $this->belongsTo(IamRole::class);
    }
    
    public function iamUser()
    {
        return $this->belongsTo(IamUser::class);
    }
    
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}