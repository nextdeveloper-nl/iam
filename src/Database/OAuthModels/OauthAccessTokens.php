<?php

namespace NextDeveloper\IAM\Database\OAuthModels;

use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\Commons\Database\Traits\UuidId;

class OauthAccessTokens extends Model
{
    use Filterable, UuidId;

    public $timestamps = false;

    public $incrementing = false;

    protected $table = 'oauth_access_tokens';

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
    }
}
