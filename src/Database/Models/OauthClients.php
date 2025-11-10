<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NextDeveloper\Commons\Common\Cache\Traits\CleanCache;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\Commons\Database\Traits\HasStates;
use NextDeveloper\Commons\Database\Traits\Taggable;
use NextDeveloper\Commons\Database\Traits\UuidId;
use NextDeveloper\IAM\Database\Observers\AccountsObserver;

/**
 * Accounts model.
 *
 * @package  NextDeveloper\IAM\Database\Models
 * @property integer $id
 * @property integer $user_id
 * @property integer $account_id
 * @property string $name
 * @property string $provider
 * @property string $secret
 * @property string $redirect
 * @property boolean $personal_access_client
 * @property boolean $password_client
 * @property boolean $revoked
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class OauthClients extends Model
{
    public $timestamps = true;

    protected $table = 'oauth_clients';


    /**
     * @var array
     */
    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'account_id',
        'name',
        'provider',
        'secret',
        'redirect',
        'personal_access_client',
        'password_client',
        'revoked'
    ];

    /**
     * Here we have the fulltext fields. We can use these for fulltext search if enabled.
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
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id'       =>  'integer',
        'account_id'    =>  'integer',
        'name'          =>  'string',
        'provider'      =>  'string',
        'secret'        =>  'string',
        'redirect'      =>  'string',
        'personal_access_client'    =>  'boolean',
        'password_client'   =>  'boolean',
        'revoked' =>  'boolean',
    ];

    /**
     * We are casting data fields.
     *
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
}
