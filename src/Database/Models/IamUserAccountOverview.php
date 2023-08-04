<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\IAM\Database\Observers\IamUserObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;

/**
 * Class IamUser.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class IamUserAccountOverview extends Model
{
    use Filterable, UuidId;

    public $timestamps = true;

    protected $table = 'iam_user_account_overview';

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
     * @var int
     */
    protected $perPage = 20;

    /**
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        self::registerScopes();
    }

    /**
     * @return void
     */
    public static function registerScopes()
    {
        $globalScopes = config('iam.scopes.global');
        $modelScopes = config('iam.scopes.iam_users');

        if (!$modelScopes) $modelScopes = [];
        if (!$globalScopes) $globalScopes = [];

        $scopes = array_merge(
            $globalScopes,
            $modelScopes
        );

        if ($scopes) {
            foreach ($scopes as $scope) {
                static::addGlobalScope(app($scope));
            }
        }
    }
}