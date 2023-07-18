<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\IAM\Database\Observers\IamAccountObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;

/**
 * Class IamAccount.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class IamAccount extends \NextDeveloper\IAM\Database\Abstract\AuthorizationModel
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
        'id'              => 'integer',
		'uuid'            => 'string',
		'name'            => 'string',
		'domain_id'       => 'integer',
		'country_id'      => 'integer',
		'currency_id'     => 'integer',
		'phone_number'    => 'string',
		'description'     => 'string',
		'owner_id'        => 'integer',
		'account_type_id' => 'integer',
		'created_at'      => 'datetime',
		'updated_at'      => 'datetime',
		'deleted_at'      => 'datetime',
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
        parent::observe(IamAccountObserver::class);
    }

    public function iamAccountType()
    {
        return $this->belongsTo(IamAccountType::class);
    }
    
    public function iamBackend()
    {
        return $this->hasMany(IamBackend::class);
    }

    public function iamRoles()
    {
        return $this->hasMany(IamRole::class);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}