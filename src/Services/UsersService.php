<?php

namespace NextDeveloper\IAM\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use NextDeveloper\Commons\Database\Models\Languages;
use NextDeveloper\IAM\Authorization\Roles\IAuthorizationRole;
use NextDeveloper\IAM\Database\Filters\UsersQueryFilter;
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
class UsersService extends AbstractUsersService {

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
    
    public static function get(UsersQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator {
        $user = UserHelper::me();

        //  If user not logged in then we dont list users
        if(!$user) {
            return new Collection();
        }

        $users = Users::filter($filter)
            ->join('iam_account_user', 'iam_users.id', '=', 'iam_account_user.iam_user_id')
            ->where('iam_account_id', UserHelper::currentAccount()->id)
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

        $user = RegistrationService::registerUser($user);

        return $user;
    }

    /**
     * Manipulating the function here
     *
     * @param array $data
     * @return Users
     * @throws \Exception
     */
    public static function create(array $data) : Users {
        if(!array_key_exists('language_id', $data)) {
            $lang = Languages::where('code', App::currentLocale())->first();

            $data['common_language_id'] = $lang->id;
        }

        return parent::create($data);
    }

    public static function getByEmail($email) : ?Users {
        $user = Users::where('email', $email)->first();

        if(!$user) {
            $user = self::createWithEmail($email);
        }

        return $user;
    }

}
