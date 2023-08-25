<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\IAM\Database\Observers\IamUserAccountOverviewObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;

/**
* Class IamUserAccountOverview.
*
* @package NextDeveloper\IAM\Database\Models
*/
class IamUserAccountOverview extends Model
{
use Filterable, UuidId;
	use SoftDeletes;


	public $timestamps = true;

protected $table = 'iam_user_account_overview';


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
'id'          => 'integer',
		'uuid'        => 'string',
		'name'        => 'string',
		'surname'     => 'string',
		'email'       => 'string',
		'fullname'    => 'string',
		'username'    => 'string',
		'about'       => 'string',
		'birthday'    => 'datetime',
		'nin'         => 'string',
		'cell_phone'  => 'string',
		'language_id' => 'integer',
		'country_id'  => 'integer',
		'created_at'  => 'datetime',
		'updated_at'  => 'datetime',
		'deleted_at'  => 'datetime',
		'user_id'     => 'integer',
		'account_id'  => 'integer',
		'is_active'   => 'boolean',
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
parent::observe(IamUserAccountOverviewObserver::class);

self::registerScopes();
}

public static function registerScopes()
{
$globalScopes = config('iam.scopes.global');
$modelScopes = config('iam.scopes.iam_user_account_overview');

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

// EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n
}