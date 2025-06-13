<?php

namespace NextDeveloper\IAM\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use NextDeveloper\Commons\Database\GlobalScopes\LimitScope;
use NextDeveloper\IAM\Database\Filters\UserRolesQueryFilter;
use NextDeveloper\IAM\Database\Models\UserRoles;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\AbstractServices\AbstractUserRolesService;

/**
 * This class is responsible from managing the data for UserRoles
 *
 * Class UserRolesService.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class UserRolesService extends AbstractUserRolesService
{

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    public static function get(UserRolesQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator{
        $roles = UserRoles::withoutGlobalScope(AuthorizationScope::class)
            ->withoutGlobalScope(LimitScope::class)
            ->filter($filter)
            ->where('iam_account_id', UserHelper::currentAccount()->id)
            ->get();

        return $roles;
    }
}
