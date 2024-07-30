<?php

namespace NextDeveloper\IAM\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use NextDeveloper\Commons\Database\Models\Languages;
use NextDeveloper\IAM\Authorization\Roles\IAuthorizationRole;
use NextDeveloper\IAM\Database\Filters\UsersQueryFilter;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Models\AccountUsers;
use NextDeveloper\IAM\Database\Models\AccountUsersPerspective;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\AbstractServices\AbstractUsersService;

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

    public static function get(UsersQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator {
        $user = UserHelper::me();

        //  If user not logged in then we dont list users
        if(!$user) {
            return new Collection();
        }

        $users = AccountUsersPerspective::filter($filter)
            ->whereRaw('id in (select iam_user_id from iam_account_user where iam_account_id = ' . UserHelper::currentAccount()->id . ')')
            ->get();

        return $users;
    }

    public static function assignUserToRole(Users $user, IAuthorizationRole $role) : void
    {
        //  We need to check first if the role is created in the database
        $role = RolesService::getRole($role);

        RolesService::assignUserToRole($user, $role);
    }

    /**
     * Registers the user just by email address
     *
     * @param $email
     * @return Users
     * @throws \Exception
     */
    public static function createWithEmail($email) : Users
    {
        $user = self::create([
            'email' =>  $email
        ]);

        AccountUsersService::create([
            'iam_account_id'    =>  UserHelper::currentAccount()->id,
            'iam_user_id'       =>  $user->id,
            'is_active'         =>  true
        ]);

        return $user;
    }

    /**
     * Manipulating the function here
     *
     * @param array $data
     * @return Users
     * @throws \Exception
     */
    public static function create(array $data, Accounts $accounts = null) : Users {
        if(!array_key_exists('common_language_id', $data)) {
            $lang = Languages::withoutGlobalScopes()->where('code', App::currentLocale())->first();

            if($lang == null)
                $lang = Languages::withoutGlobalScopes()->where('code', 'en')->first();

            $data['common_language_id'] = $lang->id;
        }

        $user = parent::create($data);

        if(!$accounts)
            $accounts = UserHelper::currentAccount();

        AccountUsersService::create([
            'iam_account_id'    =>  $accounts->id,
            'iam_user_id'       =>  $user->id,
            'is_active'         =>  true
        ]);

        return $user;
    }

    public static function getByEmail($email, $createUser = false) : ?Users {
        $user = Users::where('email', $email)->first();

        return $user;
    }
}
