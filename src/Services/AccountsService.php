<?php

namespace NextDeveloper\IAM\Services;

use App\Jobs\IAM\Accounts\NewAccountCreated;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use NextDeveloper\Commons\Exceptions\CannotCreateModelException;
use NextDeveloper\Commons\Helpers\MetaHelper;
use NextDeveloper\Events\Services\Events;
use NextDeveloper\I18n\Helpers\i18n;
use NextDeveloper\IAM\Database\Filters\AccountsQueryFilter;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Models\AccountTypes;
use NextDeveloper\IAM\Database\Models\AccountUsers;
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
    /**
     * Custom get function for Accounts
     *
     * @param AccountsQueryFilter|null $filter
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function get(AccountsQueryFilter $filter = null, array $params = []): \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $model = Accounts::filter($filter)
            ->where('iam_user_id', UserHelper::me()->id);

        return $model->paginate();
    }

    public static function update($id, array $data): Accounts
    {
        $account = Accounts::where('uuid', $id)->first();

        //  Here we are checking if according to the configuration of the system, the user can change the domain or not.
        $canChangeDomain = MetaHelper::get(
            $account,
            'can_change_domain',
            config('iam.configuration.iam_accounts.can_change_domain')
        );

        if(!$canChangeDomain) {
            unset($data['common_domain_id']);
        }

        if(count($data) == 0) {
            return $account;
        }

        return parent::update($id, $data);
    }

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
    public static function userAccounts(Users $user, $filters = null) : Collection
    {
        $userAccounts = UserAccounts::withoutGlobalScopes();

        $userAccountModel = new UserAccounts();

        if($filters == null) {
            return $userAccounts->where('iam_user_id', $user->id)->get();
        }

        foreach ($filters as $key => $value) {
            if($key == 'iam_user_id' || $key == 'iam_account_id')
                continue;

            if($userAccountModel->getCasts()[$key] == 'string')
                $userAccounts = $userAccounts->whereLike($key, '%' . $value . '%');
            else
                $userAccounts = $userAccounts->where($key, $value);
        }

        return $userAccounts->where('iam_user_id', $user->id)->get();
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
        $name = 'My personal account';

        $name = i18n::t($name, $user->common_language_id);

        $accountData = [
            'name'      =>  $name,
            'iam_user_id'  =>  $user->id,
            'iam_account_type_id'   =>  AccountTypes::withoutGlobalScopes()->where('name', 'Individual')->first()->id
        ];

        $account = Accounts::withoutGlobalScopes()->create($accountData);

        //  Creating the relation to state this is the master user of the account
        AccountUsers::create([
            'iam_user_id'   =>  $user->id,
            'iam_account_id'    =>  $account->id,
            'is_active'     =>  1
        ]);

        Events::fire('created:NextDeveloper\IAM\Accounts', $account);

        //  Also this means that this user has just created an account, meaning that he is registered. So we are
        //  going to fire the registered event for the user. And dispatch new user created job.
        //(new NewAccountCreated($account))->handle();

        //  We need to bypass the create method here because parent will look for uuid instead of an ID
        return $account;
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

    public static function addUserToAccount(Users $users, Accounts $accounts)
    {
        AccountUsers::firstOrCreate([
            'iam_user_id'       =>  $users->id,
            'iam_account_id'    =>  $accounts->id,
            'is_active'         =>  true
        ]);

        return true;
    }
}
