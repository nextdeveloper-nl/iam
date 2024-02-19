<?php

namespace NextDeveloper\IAM\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use NextDeveloper\Commons\Database\Models\Languages;
use NextDeveloper\IAM\Authorization\Roles\IAuthorizationRole;
use NextDeveloper\IAM\Database\Filters\UsersQueryFilter;
use NextDeveloper\IAM\Database\Models\AccountUsers;
use NextDeveloper\IAM\Database\Models\UserAccounts;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\AbstractServices\AbstractUsersService;
use NextDeveloper\IAM\Services\Registration\RegistrationService;

/**
 * This class is responsible from managing the data for Users
 *
 * Class UsersService.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class UsersService extends AbstractUsersService
{

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}