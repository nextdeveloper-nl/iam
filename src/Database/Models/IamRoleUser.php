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
        'account_role_id' => 'integer',
		'user_id'         => 'integer',
		'account_id'      => 'integer',
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
    
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}