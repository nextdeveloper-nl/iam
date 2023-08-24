<?php

namespace NextDeveloper\IAM\Services;

use Helpers\i18n;
use Illuminate\Support\Collection;
use NextDeveloper\Commons\Exceptions\CannotCreateModelException;
use NextDeveloper\IAM\Database\Models\IamAccount;
use NextDeveloper\IAM\Database\Models\IamAccountType;
use NextDeveloper\IAM\Database\Models\IamAccountUser;
use NextDeveloper\IAM\Database\Models\IamUser;
use NextDeveloper\IAM\Database\Models\IamUserAccountOverview;
use NextDeveloper\IAM\Database\Models\IamViewUserAccount;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamAccountService;

/**
* This class is responsible from managing the data for IamAccount
*
* Class IamAccountService.
*
* @package NextDeveloper\IAM\Database\Models
*/
class IamAccountService extends AbstractIamAccountService {

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    public static function create(array $data) : IamAccount
    {
        if(!array_key_exists('iam_user_id', $data)) {
            $user = UserHelper::me();

            if(!$user) {
                throw new CannotCreateModelException('I cannot create account without a user. Please provide a user or first create a user.');
            }

            $data['iam_user_id']   =  $user->id;
        }

        if(!array_key_exists('iam_account_type_id', $data)) {
            $accountType = IamAccountType::where('name', 'Team')->first();

            $data['iam_account_type_id'] = $accountType->id;
        }

        $account = parent::create($data);

        $relation = IamAccountUser::create([
            'iam_user_id'       =>  UserHelper::me()->id,
            'iam_account_id'    =>  $account->id,
            'is_active'         =>  false,
            'session_data'      =>  null
        ]);

        return $account;
    }

    /**
     *
     *
     * @param IamUser $user
     * @return Collection
     */
    public static function userAccounts(IamUser $user) : Collection
    {
        return IamViewUserAccount::withoutGlobalScopes()->where('iam_user_id', $user->id)->get();
    }

    /**
     * This function creates the initial account for the given user
     *
     * @param IamUser $user
     * @return IamAccount
     * @throws \Exception
     */
    public static function createInitialAccount(IamUser $user) : IamAccount
    {
        if($user->name == '')
            $name = i18n::t('My personal account');

        $accountData = [
            'name'      =>  $name,
            'iam_user_id'  =>  $user->id
        ];

        return self::create($accountData);
    }

    public static function createAccount($accountName, IamUser $user) : IamAccount
    {
        $accountData = [
            'name'  =>  $accountName,
            'iam_user_id'  =>  $user->id
        ];

        $account = self::create($accountData);

        $relation = IamAccountUser::create([
            'iam_user_id'       =>  $user->id,
            'iam_account_id'    =>  $account->id,
            'is_active'         =>  false,
            'session_data'      =>  null
        ]);

        return $account;
    }

    public static function switchToAccount($accountId, $me) : IamAccount
    {

    }
}