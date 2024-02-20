<?php

namespace NextDeveloper\IAM\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use NextDeveloper\Commons\Exceptions\CannotCreateModelException;
use NextDeveloper\I18n\Helpers\i18n;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Models\AccountTypes;
use NextDeveloper\IAM\Database\Models\UserAccounts;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Events\Accounts\AccountsUpdatedEvent;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\AbstractServices\AbstractAccountsService;

/**
 * This class is responsible from managing the data for Accounts
 *
 * Class AccountsService.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class AccountsService extends AbstractAccountsService
{

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    public static function create(array $data) : Accounts
    {
        if(!array_key_exists('iam_user_id', $data)) {
            $user = UserHelper::me();

            if(!$user) {
                throw new CannotCreateModelException('I cannot create account without a user. Please provide a user or first create a user.');
            }

            $data['iam_user_id']   =  $user->id;
        }

        if(!array_key_exists('iam_account_type_id', $data)) {
            $accountType = AccountTypes::withoutGlobalScopes()->where('name', 'Team')->first();

            $data['iam_account_type_id'] = $accountType->id;
        }

        $account = parent::create($data);

        DB::table('iam_account_user')->insert([
            'iam_user_id'       =>  $data['iam_user_id'],
            'iam_account_id'    =>  $account->id,
            'is_active'         =>  false,
            'session_data'      =>  null
        ]);

        return $account;
    }

    /**
     *
     *
     * @param Users $user
     * @return Collection
     */
    public static function userAccounts(Users $user) : Collection
    {
        return UserAccounts::withoutGlobalScopes()->where('iam_user_id', $user->id)->get();
    }

    /**
     * This function creates the initial account for the given user
     *
     * @param Users $user
     * @return Accounts
     * @throws \Exception
     */
    public static function createInitialAccount(Users $user) : Accounts
    {
        if($user->name == '')
            $name = i18n::t('My personal account');

        $accountData = [
            'name'      =>  $name,
            'iam_user_id'  =>  $user->id
        ];

        return self::create($accountData);
    }

    public static function createAccount($accountName, Users $user) : Accounts
    {
        $accountData = [
            'name'  =>  $accountName,
            'iam_user_id'  =>  $user->id
        ];

        $account = self::create($accountData);

        return $account;
    }

//    public static function switchToAccount($accountId, $me) : Accounts
//    {
//
//    }

    /**
     * This service disables account.
     *
     * @param Accounts $accounts
     * @return Accounts
     */
    public static function disable(Accounts $accounts) : Accounts {
        $accounts->update([
            'is_active' =>   false
        ]);

        event(new AccountsUpdatedEvent($accounts));

        return $accounts->fresh();
    }

    /**
     * This service enables account.
     *
     * @param Accounts $accounts
     * @return Accounts
     */
    public static function enable(Accounts $accounts) : Accounts {
        $accounts->update([
            'is_active' =>   true
        ]);

        event(new AccountsUpdatedEvent($accounts));

        return $accounts->fresh();
    }
}
