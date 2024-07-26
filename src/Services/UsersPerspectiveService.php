<?php

namespace NextDeveloper\IAM\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use NextDeveloper\IAM\Database\Filters\UsersQueryFilter;
use NextDeveloper\IAM\Database\Models\AccountUsersPerspective;
use NextDeveloper\IAM\Database\Models\UsersPerspective;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\AbstractServices\AbstractUsersPerspectiveService;

/**
 * This class is responsible from managing the data for UsersPerspective
 *
 * Class UsersPerspectiveService.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class UsersPerspectiveService extends AbstractUsersPerspectiveService
{

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    public static function get(\NextDeveloper\IAM\Database\Filters\UsersPerspectiveQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator {
        $user = UserHelper::me();

        //  If user not logged in then we dont list users
        if(!$user) {
            return new Collection();
        }

        $users = UsersPerspective::filter($filter)
            ->whereRaw('id in (select iam_user_id from iam_account_users where iam_account_id = ' . UserHelper::currentAccount()->id . ')')
            ->paginate();

        return $users;
    }
}
