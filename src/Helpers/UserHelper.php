<?php

namespace NextDeveloper\IAM\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Database\Models\Languages;
use NextDeveloper\Commons\Database\Models\Media;
use NextDeveloper\IAM\Database\Filters\AccountsQueryFilter;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Models\AccountUsers;
use NextDeveloper\IAM\Database\Models\Roles;
use NextDeveloper\IAM\Database\Models\RoleUsers;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Exceptions\CannotFindUserException;
use NextDeveloper\IAM\Services\AccountsService;
use NextDeveloper\IAM\Services\RolesService;

class UserHelper
{
    private static $user;

    private static $account;

    private static $isBypassRolesCheck = false;

    /**
     * This function returns the User object for the current logged in user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|Users|null
     */
    public static function me()
    {
        if (self::$user)
            return self::$user;

        /**
         * This will return the User object of the logged in user
         */
        $headers = request()->headers->all();
        $authorization = $headers['authorization'][0] ?? null;

        if (!$authorization)
            return null;

        $authorization = str_replace('Bearer ', '', $authorization);

        //  There is a weird situation where sometimes clients can send null or null as text.
        if(trim($authorization) == null || trim($authorization) == 'null')
            return null;

        try {
            if(!Str::isUuid($authorization)) {
                return null;
            }

            $token = DB::select("select * from oauth_access_tokens where id = ?", [$authorization]);
        } catch (\Exception $e) {
            Log::error(__METHOD__ . ' | We have an error while checking for the token: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return null;
        }

        if (!$token) {
            if(Str::startsWith(request()->getRequestUri(), '/public/')) {
                //  This is a public route, we dont need to log this as error
                return null;
            }

            Log::error('[UserHelper] Cannot find the user related to token. Maybe user is not' .
                ' registered or token is expired? Request is coming to url: ' . request()->getRequestUri());
            return null;
        }

        $user = Users::withoutGlobalScopes()
            ->where('id', $token[0]->user_id)
            ->first();

        self::$user = $user;

        return $user;
    }

    public static function getUserWithId($userId, $skipAccessCheck = false)
    {
        if($skipAccessCheck) {
            return Users::withoutGlobalScope(AuthorizationScope::class)->where('id', $userId)->first();
        }

        return Users::where('id', $userId)->first();
    }

    public static function currentUser()
    {
        return self::$user;
    }

    /**
     * This function finds the user by the given id and returns the user object.
     *
     * @param $userId
     * @return Users
     */
    public static function setUserById($userId): Users
    {
        $user = Users::withoutGlobalScopes()
            ->where('id', $userId)
            ->first();

        self::$user = $user;

        return $user;
    }

    public static function setCurrentAccountById($accountId)
    {
        $account = Accounts::withoutGlobalScopes()
            ->where('id', $accountId)
            ->first();

        self::$account = $account;

        return $account;
    }

    /**
     * Adds user to the current account. This function automatically adds the user to the master account of the user
     * and does not asks for approval. So if you are inviting a user to this account, you should NOT use this function.
     *
     * @param Users $user
     * @param Accounts|null $account
     * @return AccountUsers
     */
    public static function addUserToCurrentAccount(Users $user, Accounts $account = null): AccountUsers
    {
        if (!$account)
            $account = self::currentAccount();

        $relation = AccountUsers::create([
            'iam_user_id' => $user->id,
            'iam_account_id' => $account->id,
            'is_active' => 1
        ]);

        return $relation;
    }

    /**
     * Returns the account by Id
     *
     * @param $accountId
     * @return Accounts|null
     */
    public static function getAccountById($accountId): ?Accounts
    {
        $account = Accounts::withoutGlobalScopes()
            ->where('id', $accountId)
            ->first();

        return $account;
    }

    public static function getAccountByUuid($uuid): ?Accounts
    {
        $account = Accounts::withoutGlobalScope(AuthorizationScope::class)
            ->where('uuid', $uuid)
            ->first();

        $accountUserRelation = AccountUsers::withoutGlobalScope(AuthorizationScope::class)
            ->where('iam_account_id', $account->id)
            ->where('iam_user_id', UserHelper::me()->id)
            ->first();

        return $account;
    }

    /**
     * Returns all accounts that the user is part of.
     *
     * @param Users $user
     * @return \Illuminate\Support\Collection
     */
    public static function allAccounts(Users $user = null, AccountsQueryFilter $filter = null): \Illuminate\Support\Collection
    {
        $filters = null;

        if ($user == null)
            $user = self::me();

        if ($filter)
            $filters = $filter->filters();

        $accounts = AccountsService::userAccounts($user, $filters);

        return $accounts;
    }

    /**
     * @throws CannotFindUserException
     */
    public static function masterAccount(Users $user = null, $createAccount = false): ?Accounts
    {
        if (!$user) {
            $user = self::me();
        }

        if (!$user) {
            throw new CannotFindUserException('We could not find this user.');
        }

        $account = Accounts::withoutGlobalScopes()
            ->where('iam_user_id', $user->id)
            ->first();

        if (!$account && $createAccount) {
            $account = AccountsService::createInitialAccount($user);
        }

        return $account;
    }

    public static function getLocale(Users $users = null): Languages
    {
        if (!$users)
            $users = self::me();

        $lang = Languages::where('id', $users->common_language_id)->first();

        return $lang;
    }

    /**
     * Returns the current account for the logged in user
     *
     * @return Accounts
     */
    public static function currentAccount(Users $user = null): ?Accounts
    {
        //  :WARNING: Don't forget to change the account when the user changes the account
        if (self::$account)
            return self::$account;

        $current = null;
        $relation = null;

        if (!$user) {
            $user = self::me();
        }

        //  We have user
        if ($user) {
            if ($current)
                return $current;

            //  We are checking about the relation
            $relation = AccountUsers::withoutGlobalScope(AuthorizationScope::class)
                ->where('iam_user_id', $user->id)
                ->where('is_active', 1)
                ->first();

            //  If we don't have relation it means that we dont have current account information
            //  that is why we are creating the relation
            if (!$relation) {
                $masterAccount = self::masterAccount($user);

                //  Checking if the user has master account. If not we are creating a master account
                if ($masterAccount) {
                    //  @todo: Here we need to check if user has this relation or not.
                    try {
                        $relation = AccountUsers::create([
                            'iam_user_id' => $user->id,
                            'iam_account_id' => $masterAccount->id,
                            'is_active' => 1
                        ]);
                    } catch (\Exception $e) {
                        if ($e->getCode() == 23505) {
                            $relation = AccountUsers::withoutGlobalScopes()->where('iam_user_id', $user->id)
                                ->where('iam_account_id', $masterAccount->id)
                                ->first();

                            $relation->update([
                                'is_active' => 1
                            ]);
                        }
                    }
                } else {
                    AccountsService::createInitialAccount($user);

                    $relation = AccountUsers::where('iam_user_id', $user->id)
                        ->where('is_active', 1)
                        ->first();
                }
            }
        } else
            return null;

        if($relation) {
            $current = Accounts::withoutGlobalScope(AuthorizationScope::class)
                ->where('id', $relation->iam_account_id)
                ->first();
        }

        self::$account = $current;

        return $current;
    }

    /**
     * Switches the accounts to the given account, if the user is a member of that account
     *
     * @param Accounts $account
     * @return Accounts
     */
    public static function switchAccountTo(Accounts $account = null): Accounts
    {
        //  We need to reset the current account object not to create any problems
        self::$account = null;

        $me = self::me();

        $teams = UserHelper::allAccounts($me);;
        $isInTeam = false;

        foreach ($teams as $team) {
            if ($account->id == $team->id) {
                $isInTeam = true;
            }
        }

        if ($isInTeam) {
            foreach ($teams as $team) {
                //  We are deleting this cache since they may all be changed
                Cache::delete(
                    CacheHelper::getKey('Accounts', $team->uuid)
                );
            }

            DB::update('update iam_account_user set is_active = false where iam_user_id = ' . $me->id . ';');

            DB::update('update iam_account_user set is_active = true where iam_user_id = ' . $me->id . ' and iam_account_id = ' . $account->id . ';');

            RolesService::assignDefaultRoles($me, $account);

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
    public static function teamMates(): ?Collection
    {
        /**
         * This will return the list of people that are in the same team with this user
         */
    }

    public static function isTeamMate(Users $user): bool
    {
        //  This happens when the user is not logged in OR the background process is actually trying to create
        //  this user.
        if(!UserHelper::currentAccount())
            return false;

        $userAccountRelation = AccountUsers::withoutGlobalScope(AuthorizationScope::class)
            ->where([
                'iam_account_id'    =>  UserHelper::currentAccount()->id,
                'iam_user_id'       =>  $user->id
            ])->first();

        //  Marking this because we need to know if the user registered is being registered under his master account
        //  If user is related to an account but it's not a master account, then we set;
        if($userAccountRelation) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if the give user (if null current user) is the owner of the account. Otherwise returns false.
     *
     * @param Users|null $user
     * @return void
     */
    public static function isTeamOwner(Users $user = null) : bool
    {
        if(!$user)
            $user = self::currentUser();

        if(self::currentAccount()->iam_user_id == $user->id)
            return true;

        return false;
    }

    /**
     * Alias of isTeamOwner. Works for both.
     *
     * @param Users|null $user
     * @return bool
     */
    public static function isAccountOwner(Users $user = null) : bool
    {
        return self::isTeamOwner($user);
    }

    /**
     * This function will return all the users connected to master account and sub accounts. This list also
     * includes the current user. That is why it returns a collections.
     *
     * @return Collection Set of users in all accounts
     */
    public static function all(): Collection
    {
        /**
         * This will return all users under master account and team accounts
         */
    }

    /**
     * Returns the user with the given username
     *
     * @param $username
     * @return Users|null
     */
    public static function getWithUsername($username): ?Users
    {
        $users = Users::withoutGlobalScope(AuthorizationScope::class)
            ->where('username', $username)
            ->first();

        return $users;
    }

    /**
     * Returns the user with the given email address
     *
     * @param $email
     * @return Users
     */
    public static function getWithEmail($email): ?Users
    {
        $users = Users::withoutGlobalScope(AuthorizationScope::class)
            ->where('email', $email)
            ->first();

        return $users;
    }

    public static function getWithId($id): ?Users
    {
        if(Str::isUuid($id)) {
            return Users::withoutGlobalScope(AuthorizationScope::class)
                ->where('uuid', $id)
                ->first();
        }

        return Users::withoutGlobalScope(AuthorizationScope::class)
            ->where('id', $id)
            ->first();
    }

    /**
     * Alias for has function
     *
     * @param $string
     * @param $user
     * @return bool
     */
    public static function hasRole($string, $user = null): bool
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
    public static function has($string, $user = null): bool
    {
        //  If null getRoles will get the current user
        $roles = self::getRoles($user);

        //  This works correct, if anything goes wrong, look at the database
        foreach ($roles as $role) {
            if ($role->name == $string)
                return true;
        }

        return false;
    }

    public static function getRoleForModel($model, Users $user = null): ?Roles
    {
        $roles = self::getRoles($user);

        foreach ($roles as $role) {
            if(!class_exists($role->class)) {
                continue;
            }

            $roleClass = app($role->class);

            if ($roleClass->canBeApplied($model->getTable())) {
                return Roles::withoutGlobalScope(AuthorizationScope::class)
                    ->where('id', $role->iam_role_id)
                    ->first();
            }
        }

        return null;
    }

    public static function bypassRolesCheck($bypass = null) : bool
    {
        if($bypass && is_bool($bypass)) {
            self::$isBypassRolesCheck = $bypass;
        }

        if(self::hasRole('system-admin', self::me()))
            return true;

        return self::$isBypassRolesCheck;
    }

    public static function can($method, $model, Users $user = null)
    {
        if(self::bypassRolesCheck())
            return true;

        if (!$user)
            $user = self::me();

        if(!$user) {
            Log::error('[UserHelper@can] User is null. This means that the user is not logged in or ' .
                'the user is not registered in the system. Please check the user registration process.');

            Log::error('[UserHelper@can] Method: ' . $method . ' Model: ' . get_class($model) . ' User: ' . json_encode($user));

            return null;
        }

        $roleForModel = self::getRoleForModel($model, $user);

        if (!$roleForModel) {
            Log::warning('[UserHelper@can] $roleForModel is null. This means that the user ' .
                'does not have any role in the system. Maybe we should ');

            RolesService::assignDefaultRoles($user, self::currentAccount());

            $roleForModel = self::getRoleForModel($model, $user);

            //  If still we dont have role for the related model, this means that the role is not in the default
            //  roles. Thats why we return false.
            if(!$roleForModel)
                return false;
        }

        $roleClass = app($roleForModel->class);

        $result = $roleClass->checkPolicy($method, $model, $user);

        if (!$result)
            Log::warning('[UserHelper@can] User can not do this operation: ' . $method . ' on ' . $model->getTable() . ' with this role: ' . get_class($roleClass));

        return $result;
    }

    public static function currentRole(Users $user = null): ?Roles
    {
        trigger_deprecation('nextdeveloper/iam', '1.0', 'This function is deprecated. ' .
            'No need to switch since all roles are loaded now.');

        $currentRole = null;

        if (!$user) {
            $user = self::me();
        }

        //  If we still dont have the user then we dont have the user created.
        if (!$user) {
            return null;
        }

        $currentRole = Cache::get(
            CacheHelper::getKey('Users', $user->uuid, 'CurrentRole'),
        );

        if ($currentRole)
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
    public static function getRoles(Users $user = null): ?Collection
    {
        if (!$user)
            $user = self::me();

        $roles = RolesService::getUserRoles($user, self::currentAccount($user));

        if(!$roles) {
            if($user)
                Log::error('[UserHelper] Cannot find any roles for user: ' . $user->uuid);
            else
                Log::error('[UserHelper] Roles are trying to be access when we make this request: ' . request()->getRequestUri());
        }

        return $roles;
    }

    public static function dumpRoles(Users $user = null) : void
    {
        $roles = self::getRoles($user);

        foreach ($roles as $role) {
            dump($role->name);
        }
    }

    public static function removeFromRole($role, Users $users = null, Accounts $account = null): bool
    {
        if (!$users)
            $users = self::me();

        if (!$account)
            $account = self::currentAccount();

        if (class_basename($role) == 'UserRoles')
            $role = Roles::withoutGlobalScopes()->where('uuid', $role->uuid)->first();

        $sql = DB::raw('delete from iam_role_users where iam_user_id = ' . $users->id . ' and iam_role_id = ' . $role->id . ' and iam_account_id = ' . $account->id . ';');

        return true;
    }

    public static function switchToRoleByRoleId(Users $user = null, $roleId): ?Roles
    {
        trigger_deprecation('nextdeveloper/iam', '1.0', 'This function is deprecated. ' .
            'No need to switch since all roles are loaded now.');

        if (!$user)
            $user = self::me();

        $role = Roles::where('uuid', $roleId)->first();

        if (self::switchToRole($user, $role))
            return self::currentRole();

        return null;
    }

    /**
     * @param Users $user
     * @param Roles $role
     * @return bool
     */
    public static function switchToRole(Users $user, Roles $role): bool
    {
        trigger_deprecation('nextdeveloper/iam', '1.0', 'This function is deprecated. ' .
            'All roles are loaded now.');

        $account = self::currentAccount();

        //  Mark all other roles as not active
        $roles = RoleUsers::where('iam_user_id', $user->id)
            ->where('iam_account_id', $account->id)
            ->update([
                'is_active' => 0
            ]);

        //  Update the requested role as active
        $roles = RoleUsers::where('iam_user_id', $user->id)
            ->where('iam_account_id', $account->id)
            ->where('iam_role_id', $role->id)
            ->update([
                'is_active' => 1
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
    public static function applyUserFields(Model $model): Model
    {
        if (!self::me())
            return $model;

        if (property_exists($model, 'iam_user_id')) {
            if (!$model->iam_user_id)
                $model->iam_user_id = self::me()->id;
        } else {
            if (in_array('iam_user_id', $model->getFillable()))
                $model->iam_user_id = self::me()->id;
        }

        if (property_exists($model, 'iam_account_id')) {
            if (!$model->iam_account_id)
                $model->iam_account_id = self::currentAccount()->id;
        } else {
            if (in_array('iam_account_id', $model->getFillable()))
                $model->iam_account_id = self::currentAccount()->id;
        }

        return $model;
    }

    public static function getAccountOwner(Accounts|int $accounts): ?Users
    {
        if(is_int($accounts)) {
            $accounts = Accounts::withoutGlobalScope(AuthorizationScope::class)
                ->where('id', $accounts)
                ->first();
        }

        return Users::where('id', $accounts->iam_user_id)->first();
    }

    public static function getLeoOwner(): Users
    {
        return self::getWithEmail(config('leo.leo_owner_email'));
    }

    public static function getLeoOwnerAccount(): Accounts
    {
        return self::masterAccount(self::getLeoOwner());
    }

    public static function setAdminAsCurrentUser()
    {
        UserHelper::setUserById(config('leo.current_user_id'));
        UserHelper::setCurrentAccountById(config('leo.current_account_id'));
    }

    public static function setCurrentUserAndAccount(Users $user, Accounts $account) {
        self::setUserById($user->id);
        self::setCurrentAccountById($account->id);
    }

    /**
     * Get all users that have a specific role.
     *
     * @param string $roleName The name of the role to find users for
     */
    public static function getUsersWithRole(string $roleName, Accounts $accounts = null)
    {
        $role = RolesService::getRoleByName($roleName);

        if (!$role) {
            Log::error("[UserHelper] Role with name $roleName not found");
            return collect();
        }

        $query = Users::query()
            ->join('iam_role_user', 'iam_role_user.iam_user_id', '=', 'iam_users.id')
            ->where('iam_role_user.iam_role_id', $role->id)
            ->where('iam_role_user.is_active', 1)
            ->select('iam_users.*')
            ->distinct();

        if($accounts) {
            $query->where('iam_role_user.iam_account_id', $accounts->id);
        }

        // Get users with a role in one query using join
        return $query->get();
    }

    public static function getUsersProfilePictureUrl(string $email, string $profilePictureIdentity = null): string
    {
        $profile_picture_url = null;

        if($profilePictureIdentity != null) {
            $profilePicture = Media::where('id', $profilePictureIdentity)
                ->first();

            $profile_picture_url = $profilePicture?->cdn_url;
        }

        // Use Gravatar as fallback when the profile picture is not available
        if(!$profile_picture_url) {
            $profile_picture_url = UserHelper::getGravatarUrl($email ?? null);
        }

        return $profile_picture_url;
    }

    public static function getGravatarUrl(?string $email, int $size = 200, string $default = 'identicon'): string
    {
        if (!$email) {
            return "https://www.gravatar.com/avatar/?s={$size}&d={$default}";
        }

        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d={$default}";
    }
}
