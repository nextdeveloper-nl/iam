<?php

namespace NextDeveloper\IAM\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\AccountUsers;
use NextDeveloper\IAM\Database\Models\Roles;
use NextDeveloper\IAM\Database\Models\RoleUsers;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Exceptions\CannotFindUserException;
use NextDeveloper\IAM\Services\AccountsService;
use NextDeveloper\IAM\Services\RolesService;
use NextDeveloper\IAM\Services\UsersService;

//  This is just an alias for UserHelper for fast coding.
class U extends UserHelper {}

class UserHelper
{
    /**
     * This function returns the User object for the current logged in user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|Users|null
     */
    public static function me()
    {
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
     * @param Users $user
     * @return \Illuminate\Support\Collection
     */
    public static function allAccounts(Users $user = null) : \Illuminate\Support\Collection
    {
        if($user == null)
            $user = self::me();

        $accounts = AccountsService::userAccounts($user);

        return $accounts;
    }

    /**
     * @throws CannotFindUserException
     */
    public static function masterAccount(Users $user = null) : Accounts
    {
        if(!$user) {
            $user = self::me();
        }

        if(!$user) {
            throw new CannotFindUserException();
        }

        $account = Accounts::where('iam_user_id', $user->id)->first();

        if(!$account) {
            $account = AccountsService::createInitialAccount($user);
        }

        return $account;
    }

    /**
     * Returns the current account for the logged in user
     *
     * @return Accounts
     */
    public static function currentAccount(Users $user = null) : ?Accounts
    {
        $current = null;
        $relation = null;

        if(!$user) {
            $user = self::me();
        }

        //  We have user
        if($user) {
            //  We are checking if we have it in cache. If we have we will return it.
            $current = Cache::get(
                CacheHelper::getKey('Users', $user->uuid, 'CurrentAccount')
            );

            if($current)
                return $current;

            //  We are checking about the relation
            $relation = AccountUsers::withoutGlobalScope(AuthorizationScope::class)
                ->where('id', $user->id)
                ->where('is_active', 1)
                ->first();

            //  If we don't have relation it means that we dont have current account information
            //  that is why we are creating the relation
            if(!$relation) {
                $masterAccount = self::masterAccount($user);

                //  Checking if the user has master account. If not we are creating a master account
                if($masterAccount) {
                    $relation = AccountUsers::create([
                        'iam_user_id'   =>  $user->id,
                        'iam_account_id'    =>  $masterAccount->id,
                        'is_active'     =>  1
                    ]);
                } else {
                    $masterAccount = AccountsService::createInitialAccount($user);

                    $relation = AccountUsers::where('iam_user_id', $user->id)
                        ->where('is_active', 1)
                        ->first();
                }
            }
        }
        else
            return null;

        $current = Accounts::withoutGlobalScope(AuthorizationScope::class)
            ->where('id', $relation->iam_account_id)
            ->first();

        Cache::set(
            CacheHelper::getKey('Users', $user->uuid, 'CurrentAccount'),
            $current
        );

        return $current;
    }

    /**
     * Switches the accounts to the given account, if the user is a member of that account
     *
     * @param Accounts $account
     * @return Accounts
     */
    public static function switchAccountTo(Accounts $account = null) : Accounts
    {
        $me = self::me();

        $teams = UserHelper::allAccounts($me);

        $isInTeam = false;

        foreach ($teams as $team) {
            if($account->id == $team->id) {
                $isInTeam = true;
            }
        }

        if($isInTeam) {
            foreach ($teams as $team) {
                //  We are deleting this cache since they may all be changed
                Cache::delete(
                    CacheHelper::getKey('Accounts', $team->uuid)
                );
            }

            AccountUsers::where('iam_user_id', $me->id)
                ->update([
                    'is_active' =>  0
                ]);

            AccountUsers::where('iam_user_id', $me->id)
                ->where('iam_account_id', $account->id)
                ->update([
                    'is_active' =>  1
                ]);

            Cache::delete(
                CacheHelper::getKey('Users', $me->uuid)
            );
        }

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
     * @return Users
     */
    public static function getWithEmail($email) : Users
    {
        $users = Users::where('email', $email)->first();

        return $users;
    }

    public static function hasAccount($accountId) : ?Accounts
    {

    }

    public static function currentRole(Users $user = null) : ?Roles
    {
        $currentRole = null;

        if(!$user) {
            $user = self::me();
        }

        //  If we still dont have the user then we dont have the user created.
        if(!$user) {
            return null;
        }

        $currentRole = Cache::get(
            CacheHelper::getKey('Users', $user->uuid, 'CurrentRole'),
        );

        if($currentRole)
            return $currentRole;

        $role = RolesService::getUserRole($user, self::currentAccount($user));

        Cache::delete(
            CacheHelper::getKey('Users', $user->uuid, 'CurrentRole'),
            $role
        );

        return $role;
    }

    public static function switchToRoleByRoleId(Users $user = null, $roleId) : ?Roles
    {
        if(!$user)
            $user = self::me();

        $role = Roles::where('uuid', $roleId)->first();

        if(self::switchToRole($user, $role))
            return self::currentRole();

        return null;
    }

    public static function switchToRole(Users $user, Roles $role) : bool
    {
        $account = self::currentAccount();

        //  Mark all other roles as not active
        $roles = RoleUsers::where('iam_user_id', $user->id)
            ->where('iam_account_id', $account->id)
            ->update([
                'is_active' =>  0
            ]);

        //  Update the requested role as active
        $roles = RoleUsers::where('iam_user_id', $user->id)
            ->where('iam_account_id', $account->id)
            ->where('iam_role_id', $role->id)
            ->update([
                'is_active' =>  1
            ]);

        $currentRole = Cache::set(
            CacheHelper::getKey('Users', $user->uuid, 'CurrentRole'),
            $role
        );

        return true;
    }

    /**
     * Applies user fields to the object before creating it.
     *
     * @param $model
     * @return void
     */
    public static function applyUserFields(Model $model) : Model {
        $model->iam_user_id     =   self::me()->id;
        $model->iam_account_id  =   self::currentAccount()->id;

        return $model;
    }

    public static function getAccountOwner(Accounts $accounts) : Users {
        throw new \Exception('This function is not implemented yet!');
    }
}
