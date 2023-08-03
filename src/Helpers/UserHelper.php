<?php

namespace NextDeveloper\IAM\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use NextDeveloper\IAM\Database\Models\IamUser;
use NextDeveloper\IAM\Database\Models\IamAccount;
use NextDeveloper\IAM\Exceptions\CannotFindUserException;
use NextDeveloper\IAM\Services\IamAccountService;

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

        return Auth::guard( 'api' )->user();
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

        $account = IamAccount::where('owner_id', $user->id)->first();

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
    public static function currentAccount() : IamAccount
    {
        $current = self::me()->iamAccount()->wherePivot('is_active', 1)->first();

        if(!$current) {
            self::me()->iamAccount()->attach(
                self::masterAccount()->id
            );

            $current = self::me()->iamAccount()->wherePivot('is_active', 1)->first();
        }

        return $current;
    }

    /**
     * Switches the accounts to the given account, if the user is a member of that account
     *
     * @param IamAccount $account
     * @return IamAccount
     */
    public static function switchAccountTo(IamAccount $account) : IamAccount
    {
        return self::currentAccount();
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
}