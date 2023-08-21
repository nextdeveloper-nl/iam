<?php

namespace NextDeveloper\IAM\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\IamRole;
use NextDeveloper\IAM\Database\Models\IamRoleUser;
use NextDeveloper\IAM\Database\Models\IamUser;
use NextDeveloper\IAM\Database\Models\IamAccount;
use NextDeveloper\IAM\Database\Models\IamUserRoleOverview;
use NextDeveloper\IAM\Exceptions\CannotFindUserException;
use NextDeveloper\IAM\Services\IamAccountService;
use NextDeveloper\IAM\Services\IamRoleService;

//  This is just an alias for UserHelper for fast coding.
class U extends UserHelper {}

class UserHelper
{
    /**
     * This function returns the User object for the current logged in user.
     *
     * @return IamUser
     */
    public static function me() : ?IamUser {
        /**
         * This will return the User object of the logged in user
         */
//        dump('REQ');
//        dump(\request()->getPayload());

        return Auth::guard( 'api' )->user();
    }

    /**
     * Returns all accounts that the user is part of.
     *
     * @param IamUser $user
     * @return \Illuminate\Support\Collection
     */
    public static function allAccounts(IamUser $user = null) : \Illuminate\Support\Collection
    {
        if($user == null)
            $user = self::me();

        $accounts = IamAccountService::userAccounts($user);

        return $accounts;
    }

    /**
     * @throws CannotFindUserException
     */
    public static function masterAccount(IamUser $user = null) : IamAccount
    {
        if(!$user) {
            $user = self::me();
        }

        if(!$user) {
            throw new CannotFindUserException();
        }

        $account = IamAccount::where('iam_user_id', $user->id)->first();

        if(!$account) {
            $account = IamAccountService::createInitialAccount($user);
        }

        return $account;
    }

    /**
     * Returns the current account for the logged in user
     *
     * @return IamAccount
     */
    public static function currentAccount(IamUser $user = null) : ?IamAccount
    {
        $current = null;

        if(!$user) {
            $user = self::me();
        }

        if($user) {
            $current = Cache::get(
                CacheHelper::getKey('IamUser', $user->uuid, 'CurrentAccount')
            );

            if($current)
                return $current;

            $current = $user->iamAccount()->wherePivot('is_active', 1)->first();
        }
        else
            return null;


        if(!$current) {
            self::me()->iamAccount()->attach(
                self::masterAccount()->id
            );

            $current = self::me()->iamAccount()->wherePivot('is_active', 1)->first();
        }

        Cache::set(
            CacheHelper::getKey('IamUser', $user->uuid, 'CurrentAccount'),
            $current
        );


        return $current;
    }

    /**
     * Switches the accounts to the given account, if the user is a member of that account
     *
     * @param IamAccount $account
     * @return IamAccount
     */
    public static function switchAccountTo(IamAccount $account = null) : IamAccount
    {
        if(!$account)
            return self::currentAccount();

        // @todo:  Here we need to check the account ownership and return default account instead
    }

    /**
     * This function returns the list of team mates of the User. This means that we return the list of Users
     * that are also the part of "Current account".
     *
     * @return Collection
     */
    public static function teamMates() :?Collection {
        /**
         * This will return the list of people that are in the same team with this user
         */
    }

    /**
     * This function will return all the users connected to master account and sub accounts. This list also
     * includes the current user. That is why it returns a collections.
     *
     * @return Collection Set of users in all accounts
     */
    public static function all() :Collection {
        /**
         * This will return all users under master account and team accounts
         */
    }

    /**
     * Returns the user with the given email address
     *
     * @param $email
     * @return IamUser
     */
    public static function getWithEmail($email) : IamUser
    {
        $users = IamUser::where('email', $email)->first();

        return $users;
    }

    public static function hasAccount($accountId) : ?IamAccount
    {

    }

    public static function currentRole(IamUser $user = null) : ?IamRole
    {
        if(!$user) {
            $user = self::me();
        }

        $currentRole = Cache::get(
            CacheHelper::getKey('IamUser', $user->uuid, 'CurrentRole'),
        );

        if($currentRole)
            return $currentRole;

        $role = IamRoleService::getUserRole($user, self::currentAccount($user));

        $currentRole = Cache::delete(
            CacheHelper::getKey('IamUser', $user->uuid, 'CurrentRole'),
            $role
        );

        return $role;
    }

    public static function switchToRoleByRoleId(IamUser $user = null, $roleId) : ?IamRole
    {
        if(!$user)
            $user = self::me();

        $role = IamRole::where('uuid', $roleId)->first();

        if(self::switchToRole($user, $role))
            return self::currentRole();

        return null;
    }

    public static function switchToRole(IamUser $user, IamRole $role) : bool
    {
        $account = self::currentAccount();

        //  Mark all other roles as not active
        $roles = IamRoleUser::where('iam_user_id', $user->id)
            ->where('iam_account_id', $account->id)
            ->update([
                'is_active' =>  0
            ]);

        //  Update the requested role as active
        $roles = IamRoleUser::where('iam_user_id', $user->id)
            ->where('iam_account_id', $account->id)
            ->where('iam_role_id', $role->id)
            ->update([
                'is_active' =>  1
            ]);

        $currentRole = Cache::set(
            CacheHelper::getKey('IamUser', $user->uuid, 'CurrentRole'),
            $role
        );

        return true;
    }
}