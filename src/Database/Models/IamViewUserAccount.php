<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\IAM\Database\Observers\IamViewUserAccountObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;

/**
* Class IamViewUserAccount.
*
* @package NextDeveloper\IAM\Database\Models
*/
class IamViewUserAccount extends Model
{
use Filterable, UuidId;
	use SoftDeletes;


	public $timestamps = true;

protected $table = 'iam_view_user_accounts';


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
		'is_active'           => 'boolean',
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
parent::observe(IamViewUserAccountObserver::class);

self::registerScopes();
}

public static function registerScopes()
{
$globalScopes = config('iam.scopes.global');
$modelScopes = config('iam.scopes.iam_view_user_accounts');

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