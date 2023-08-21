<?php

namespace NextDeveloper\IAM\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use NextDeveloper\Commons\Database\Models\CommonLanguage;
use NextDeveloper\IAM\Authorization\Roles\IAuthorizationRole;
use NextDeveloper\IAM\Database\Filters\IamUserQueryFilter;
use NextDeveloper\IAM\Database\Models\IamUser;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamUserService;
use NextDeveloper\IAM\Services\Registration\RegistrationService;

/**
* This class is responsible from managing the data for IamUser
*
* Class IamUserService.
*
* @package NextDeveloper\IAM\Database\Models
*/
class IamUserService extends AbstractIamUserService {

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    public static function get(IamUserQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator {
        $user = UserHelper::me();

        //  If user not logged in then we dont list users
        if(!$user) {
            return new Collection();
        }

        $users = IamUser::filter($filter)
            ->join('iam_account_user', 'iam_users.id', '=', 'iam_account_user.iam_user_id')
            ->where('iam_account_id', UserHelper::currentAccount()->id)
            ->get();

        return $users;
    }

    public static function assignUserToRole(IamUser $user, IAuthorizationRole $role) : void
    {
        //  We need to check first if the role is created in the database
        $role = IamRoleService::getRole($role);

        IamRoleService::assignUserToRole($user, $role);
    }

    /**
     * Registers the user just by email address
     *
     * @param $email
     * @return IamUser
     * @throws \Exception
     */
    public static function createWithEmail($email) : IamUser
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
     * @return IamUser
     * @throws \Exception
     */
    public static function create(array $data) : IamUser {
        if(!array_key_exists('language_id', $data)) {
            $lang = CommonLanguage::where('code', App::currentLocale())->first();

            $data['language_id'] = $lang->id;
        }

        return parent::create($data);
    }

    public static function getByEmail($email) : ?IamUser {
        $user = IamUser::where('email', $email)->first();

        if(!$user) {
            $user = self::createWithEmail($email);
        }

        return $user;
    }
}