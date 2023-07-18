<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\IAM\Database\Observers\IamLoginLogObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;

/**
 * Class IamLoginLog.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class IamLoginLog extends Model
{
    use Filterable, UuidId;
    

    public $timestamps = true;

    protected $table = 'iam_login_logs';


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
        'id'         => 'integer',
		'uuid'       => 'string',
		'user_id'    => 'integer',
		'created_at' => 'datetime',
    ];

    /**
     * We are casting data fields.
     * @var array
     */
    protected $dates = [
        'created_at',
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
        parent::observe(IamLoginLogObserver::class);
    }

    public function iamUser()
    {
        return $this->belongsTo(IamUser::class);
    }
    
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}