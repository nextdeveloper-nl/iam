<?php

namespace NextDeveloper\IAM\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Database\Models\Languages;
use NextDeveloper\Events\Services\Events;
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

class UserHelper
{
    private static $user;

    /**
     * This function returns the User object for the current logged in user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|Users|null
     */
    public static function me()
    {
        if(self::$user)
            return self::$user;

        /**
         * This will return the User object of the logged in user
         */
        $headers = request()->headers->all();
        $authorization = $headers['authorization'][0] ?? null;

        if(!$authorization)
            return null;

        $authorization = str_replace('Bearer ', '', $authorization);

        $token = DB::select("select * from oauth_access_tokens where id = ?", [$authorization]);

        if(!$token) {
            return null;
        }

        $user = Users::withoutGlobalScopes()
            ->where('id', $token[0]->user_id)
            ->first();

        self::$user = $user;

        return $user;
    }

    public static function currentUser()
    {
        return self::$user;
    }

    /**
     * This function finds the user by the given id and returns the user object.
     *
     * @param $userId
     * @return void
     */
    public static function setUserById($userId) {
        $user = Users::withoutGlobalScopes()
            ->where('id', $userId)
            ->first();

        \SessionRegistry::set('user', $user);

        self::$user = $user;

        return $user;
    }

    /**
     * Adds user to the current account. This function automatically adds the user to the master account of the user
     * and does not asks for approval. So if you are inviting a user to this account, you should NOT use this function.
     *
     * @param Users $user
     * @param Accounts|null $account
     * @return AccountUsers
     */
    public static function addUserToCurrentAccount(Users $user, Accounts $account = null) : AccountUsers
    {
        if(!$account)
            $account = self::currentAccount();

        $relation = AccountUsers::create([
            'iam_user_id'   =>  $user->id,
            'iam_account_id'    =>  $account->id,
            'is_active'     =>  1
        ]);

        return $relation;
    }

    /**
     * Returns the account by Id
     *
     * @param $accountId
     * @return Accounts|null
     */
    public static function getAccountById($accountId) : ?Accounts
    {
        $account = Accounts::withoutGlobalScopes()
            ->where('id', $accountId)
            ->first();

        return $account;
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

        $account = Accounts::withoutGlobalScopes()
            ->where('iam_user_id', $user->id)
            ->first();

        if(!$account) {
            $account = AccountsService::createInitialAccount($user);
        }

        return $account;
    }

    public static function getLocale(Users $users = null) : Languages {
        if(!$users)
            $users = self::me();

        $lang = Languages::where('id', $users->common_language_id)->first();

        return $lang;
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
            if($current)
                return $current;

            //  We are checking about the relation
            $relation = AccountUsers::withoutGlobalScope(AuthorizationScope::class)
                ->where('iam_user_id', $user->id)
                ->where('is_active', 1)
                ->first();

            //  If we don't have relation it means that we dont have current account information
            //  that is why we are creating the relation
            if(!$relation) {
                $masterAccount = self::masterAccount($user);

                //  Checking if the user has master account. If not we are creating a master account
                if($masterAccount) {
                    //  @todo: Here we need to check if user has this relation or not.
                    try {
                        $relation = AccountUsers::create([
                            'iam_user_id'   =>  $user->id,
                            'iam_account_id'    =>  $masterAccount->id,
                            'is_active'     =>  1
                        ]);
                    } catch (\Exception $e) {
                        if($e->getCode() == 23505) {
                            $relation = AccountUsers::withoutGlobalScopes()->where('iam_user_id', $user->id)
                                ->where('iam_account_id', $masterAccount->id)
                                ->first();

                            $relation->update([
                                'is_active' =>  1
                            ]);
                        }
                    }
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
    public static function getWithEmail($email) : ?Users
    {
        $users = Users::withoutGlobalScope(AuthorizationScope::class)
            ->where('email', $email)
            ->first();

        return $users;
    }

    public static function hasAccount($accountId) : ?Accounts
    {

    }

    /**
     * Alias for has function
     *
     * @param $string
     * @param $user
     * @return bool
     */
    public static function hasRole($string, $user = null) : bool
    {
        return self::has($string, $user);
    }

    /**
     * Checks if the user has related role
     *
     * @param $string
     * @param $user
     * @return bool
     */
    public static function has($string, $user = null) : bool
    {
        //  If null getRoles will get the current user
        $roles = self::getRoles($user);

        foreach ($roles as $role) {
            if($role->name == $string)
                return true;
        }

        return false;
    }

    public static function can($method, $model) {
        $roles = self::getRoles();

        $operation = $model->getTable();

        switch ($method) {
            case 'read':
                $operation .= ':read';
                break;
            case 'create':
                $operation .= ':create';
                break;
            case 'update':
                $operation .= ':update';
                break;
            case 'delete':
                $operation .= ':delete';
                break;
        }

        foreach ($roles as $role) {
            Log::info('[UserHelper@can] role name: ' . $role->name);

            if (!$role->class) {
                UserHelper::removeFromRole($role);
                continue;
            }

            $role = app($role->class);

            if($role->canBeApplied($model->getTable())) {
                if(in_array($operation, $role->allowedOperations())) {
                    Log::info('[UserHelper@can] My user can do this operation: ' . $operation);
                    return true;
                }
            }
        }

        Log::info('[UserHelper@can] My user cannot do this operation: ' . $operation);
        return false;
    }

    public static function currentRole(Users $user = null) : ?Roles
    {
        trigger_deprecation('nextdeveloper/iam', '1.0', 'This function is deprecated. ' .
            'No need to switch since all roles are loaded now.');

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

    /**
     * Returns the roles of the user
     *
     * @param Users|null $user
     * @return Roles|null
     */
    public static function getRoles(Users $user = null) : ?Collection
    {
        if(!$user)
            $user = self::me();

        $roles = RolesService::getUserRoles($user, self::currentAccount($user));

        return $roles;
    }

    public static function removeFromRole($role, Users $users = null, Accounts $account = null) :bool {
        if(!$users)
            $users = self::me();

        if(!$account)
            $account = self::currentAccount();

        if(class_basename($role) == 'UserRoles')
            $role = Roles::withoutGlobalScopes()->where('uuid', $role->uuid)->first();

        $sql = DB::raw('delete from iam_role_users where iam_user_id = ' . $users->id . ' and iam_role_id = ' . $role->id . ' and iam_account_id = ' . $account->id . ';');

        return true;
    }

    public static function switchToRoleByRoleId(Users $user = null, $roleId) : ?Roles
    {
        trigger_deprecation('nextdeveloper/iam', '1.0', 'This function is deprecated. ' .
            'No need to switch since all roles are loaded now.');

        if(!$user)
            $user = self::me();

        $role = Roles::where('uuid', $roleId)->first();

        if(self::switchToRole($user, $role))
            return self::currentRole();

        return null;
    }

    /**
     * @param Users $user
     * @param Roles $role
     * @return bool
     */
    public static function switchToRole(Users $user, Roles $role) : bool
    {
        trigger_deprecation('nextdeveloper/iam', '1.0', 'This function is deprecated. ' .
            'All roles are loaded now.');

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
        if(!self::me())
            return $model;

        if(property_exists($model, 'iam_user_id')) {
            if(!$model->iam_user_id)
                $model->iam_user_id = self::me()->id;
        } else {
            if(in_array('iam_user_id', $model->getFillable()))
                $model->iam_user_id = self::me()->id;
        }

        if(property_exists($model, 'iam_account_id')) {
            if(!$model->iam_account_id)
                $model->iam_account_id = self::currentAccount()->id;
        } else {
            if(in_array('iam_account_id', $model->getFillable()))
                $model->iam_account_id = self::currentAccount()->id;
        }

        return $model;
    }

    public static function getAccountOwner(Accounts $accounts) : Users {
        throw new \Exception('This function is not implemented yet!');
    }
}
