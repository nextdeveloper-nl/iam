<?php

namespace NextDeveloper\IAM\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Database\GlobalScopes\LimitScope;
use NextDeveloper\IAM\Authorization\Roles\IAuthorizationRole;
use NextDeveloper\IAM\Authorization\Roles\MemberRole;
use NextDeveloper\IAM\Database\Filters\RolesQueryFilter;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Models\Roles;
use NextDeveloper\IAM\Database\Models\RoleUsers;
use NextDeveloper\IAM\Database\Models\UserRoles;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\AbstractServices\AbstractRolesService;

/**
 * This class is responsible from managing the data for Roles
 *
 * Class RolesService.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class RolesService extends AbstractRolesService
{

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    /**
     * Roles that can never be assigned through the services or the API (system-viewer exposes platform-wide
     * system information, so it is only ever set up outside of the application).
     */
    public const NON_ASSIGNABLE_ROLES = ['system-admin', 'system-viewer', 'account-owner'];  //  account-owner (#1305) only via AccountsService::addCoOwner() / transferPrimaryOwnership()

    /**
     * Roles that are left out of the list of available roles (get()), as they can not be assigned anyway.
     */
    public const HIDDEN_ROLES = ['system-viewer', 'account-owner'];

    /**
     * Roles a customer account owner may see and grant to members of their own account (leo4#1304). Explicit
     * allow-list: every other role (all *-admin roles, system roles, staff roles) is neither listed nor assignable
     * for customers.
     */
    //  accounting-manager and agreement-user are NOT customer-assignable: accounting-manager's apply() returned live
    //  payment gateway data of every account; agreement-user is a default role every user already gets at registration.
    //  Staff and the partner onboarding assign accounting-manager directly. affiliate-user stays assignable; its
    //  apply() now filters by account (Affiliate package).
    public const CUSTOMER_ASSIGNABLE_ROLES = [
        'member',
        'accounting-user',
        'affiliate-user', 'agenda-user',
        'ai-user', 'ai-manager',
        'autoquill-user', 'autoquill-sales-person',
        'blog-reader', 'blog-author', 'blog-editor', 'blog-sales-person',
        'cloud-resource-owner', 'cloud-sales-person',
        'commons-user', 'communication-member',
        'dns-user', 'dns-manager',
        'events-user',
        'flow-user', 'flow-manager',
        'google-ads-user',
        'integration-platform-user',
        'intelligence-user', 'intelligence-sales-person',
        'ipaas-sales-person',
        'lms-user',
        'marketing-manager',
        'marketplace-user', 'marketplace-vendor', 'marketplace-sales-person',
        'monitoring-user', 'monitoring-manager',
        'partnership-user', 'partnership-manager',
        's3-user', 's3-manager',
        'sales-person', 'sales-manager',
        'stay-user',
        'support-user',
    ];

    public static function isCustomerAssignable(string $roleName): bool
    {
        return in_array(strtolower($roleName), self::CUSTOMER_ASSIGNABLE_ROLES, true);
    }

    /**
     * Whether a console process counts as the platform for mayManageAdminRoles(). On by default; tests switch it off
     * to exercise the request path, since PHPUnit itself runs in the console.
     */
    public static bool $consoleIsPlatform = true;

    public static function isAdminRole(string $roleName): bool
    {
        return str_ends_with(strtolower($roleName), '-admin');
    }

    /**
     * Only the platform itself may hand out or list admin roles: system-admin, a bypassed role check
     * (UserHelper::runAsAdmin) or the console (seeders, commands).
     */
    public static function mayManageAdminRoles(): bool
    {
        return (self::$consoleIsPlatform && app()->runningInConsole())
            || UserHelper::bypassRolesCheck()
            || UserHelper::hasRole('system-admin');
    }

    /**
     * Companion roles (#1303): assigning the key role also assigns the listed roles in the same account.
     * Applied centrally in assignUserToRole() so every path (module enable, CRM account create, panel, API) gets it.
     * Removal: the companion role is intentionally left in place when the key role is removed (it may be held
     * for other reasons and there is no record of whether it was added automatically).
     */
    public const COMPANION_ROLES = [
        'sales-manager' => ['flow-manager'],
    ];

    /**
     * Throws if the given role (uuid or integer id) is one of the NON_ASSIGNABLE_ROLES. Used by the create and
     * update paths of the user-role services, so the role can not be assigned or swapped in through the API.
     *
     * @throws \Exception
     */
    public static function assertAssignable($role) : void
    {
        if ($role === null || $role === '') {
            return;
        }

        $column = is_int($role) || ctype_digit((string) $role) ? 'id' : 'uuid';

        $found = Roles::withoutGlobalScope(AuthorizationScope::class)->where($column, $role)->first();

        if ($found && in_array($found->name, self::NON_ASSIGNABLE_ROLES, true)) {
            throw new \Exception('The role ' . $found->name . ' can not be assigned to users.');
        }

        // The user-role APIs only hand out customer-assignable roles (leo4#1304). Admin roles, staff roles
        // (iam-success-manager, support-specialist, ...) and anything not on the allow-list stay with the platform
        // itself. The admin suffix check is kept as a second line of defence.
        if ($found && ! self::mayManageAdminRoles()
            && (self::isAdminRole($found->name) || ! self::isCustomerAssignable($found->name))) {
            throw new \Exception('The role ' . $found->name . ' can not be assigned to users.');
        }
    }
    public static function get(?RolesQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator{
        $roles = UserHelper::getRoles();

        $level = 255;

        foreach ($roles as $role) {
            if($role->level < $level) {
                $level = $role->level;
            }
        }

        $query = Roles::withoutGlobalScope(AuthorizationScope::class)
            ->filter($filter)
            ->where('level', '>=', $level)
            ->whereNotIn('name', self::HIDDEN_ROLES);

        // Customers only see the roles they may grant, never admin or staff roles (leo4#1304)
        if (! self::mayManageAdminRoles()) {
            $query->whereIn('name', self::CUSTOMER_ASSIGNABLE_ROLES);
        }

        $roles = $query->get();

        return $roles;
    }

    /**
     * Returns the role.
     *
     * @throws \Exception
     */
    public static function getRole(IAuthorizationRole $role) : Roles
    {
        $Roles = Roles::withoutGlobalScope(AuthorizationScope::class)
            ->where('name', $role::NAME)
            ->first();

        if(!$Roles) {
            $Roles = RolesService::createRoleFromScope($role);
        }

        return $Roles;
    }

    public static function assignDefaultRoles(Users $user, Accounts $account)
    {
        $defaultRoles = config('leo.register.default_roles');

        if(!$defaultRoles) {
            return;
        }

        //  Perf: this runs on every /my/current-account call. Previously each default role cost ~4 queries
        //  (name lookup, relation lookup, update, re-read) even when nothing changed. Now we load the user's
        //  already-active role names in a single join query and only process the roles that are missing.
        $activeRoleNames = RoleUsers::withoutGlobalScopes()
            ->join('iam_roles', 'iam_roles.id', '=', 'iam_role_user.iam_role_id')
            ->where('iam_role_user.iam_user_id', $user->id)
            ->where('iam_role_user.iam_account_id', $account->id)
            ->where('iam_role_user.is_active', true)
            ->pluck('iam_roles.name')
            ->map(fn($name) => strtolower($name))
            ->all();

        foreach ($defaultRoles as $roleName) {
            //  Already assigned and active, nothing to do
            if(in_array(strtolower($roleName), $activeRoleNames, true)) {
                continue;
            }

            $getRole = RolesService::getRoleByName($roleName);

            if(!$getRole) {
                Log::error(__METHOD__ . ' | Applying default roles but cannot find this role; ' . $roleName);
                continue;
            }

            RolesService::assignUserToRole($user, $getRole, $account);
        }
    }

    /**
     * Assigns the roles listed in leo.register.owner_roles to the user, only if the user is the owner
     * of the given account. Does nothing for non-owners. Safe to call repeatedly since
     * assignUserToRole does not duplicate existing relations.
     *
     * @param Users $user
     * @param Accounts $account
     * @return void
     */
    public static function assignOwnerRoles(Users $user, Accounts $account): void
    {
        //  Ownership is defined by the account's iam_user_id, same rule as UserHelper::isAccountOwner()
        if ($account->iam_user_id != $user->id) {
            return;
        }

        $ownerRoles = config('leo.register.owner_roles');

        if (!$ownerRoles) {
            return;
        }

        foreach ($ownerRoles as $roleName) {
            $getRole = RolesService::getRoleByName($roleName);

            if (!$getRole) {
                Log::error(__METHOD__ . ' | Applying owner roles but cannot find this role; ' . $roleName);
                continue;
            }

            RolesService::assignUserToRole($user, $getRole, $account);
        }
    }

    /**
     * Returns the role if it exists in database. If not returns null.
     *
     * @param string $role
     * @return Roles
     */
    public static function getRoleByName(string $role) : ?Roles
    {
        return Roles::withoutGlobalScope(AuthorizationScope::class)
            ->whereLike('name', $role)
            ->first();
    }

    /**
     * Returns the roles of the user
     *
     * @param Users $user
     * @param Accounts $account
     * @return array
     */
    public static function getUserRoles($user, $account) :?Collection
    {
        if(!$account)
            return null;

        if(!$user) {
            //  $user is null here (eg. queue jobs / NATS handlers with no authenticated request).
            //  request() is unreliable outside an HTTP context: Laravel hands back a freshly
            //  instantiated default Request (hence the "Symfony" user-agent / localhost URL seen
            //  in older logs), which tells us nothing about the real caller. A backtrace plus
            //  explicit console/queue context is what actually identifies where this call came from.
            $runningInConsole = app()->runningInConsole();

            Log::error('[RolesService@getUserRoles] $user is null. Context: ' . json_encode([
                'account_uuid' => $account->uuid ?? null,
                'running_in_console' => $runningInConsole,
                'console_command' => $runningInConsole ? implode(' ', $_SERVER['argv'] ?? []) : null,
                'url' => $runningInConsole ? null : request()->fullUrl(),
                'method' => $runningInConsole ? null : request()->method(),
                'route' => $runningInConsole ? null : optional(request()->route())->getName(),
                'action' => $runningInConsole ? null : optional(request()->route())->getActionName(),
                'trace' => collect(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10))
                    ->skip(1)
                    ->map(fn($frame) => ($frame['class'] ?? '') . ($frame['type'] ?? '') . $frame['function']
                        . '() at ' . ($frame['file'] ?? '?') . ':' . ($frame['line'] ?? '?'))
                    ->values()
                    ->all(),
            ]));

            return null;
        }

        $roles = UserRoles::withoutGlobalScope(AuthorizationScope::class)
            // Here we have limits scope because if a user has more than 20 roles,
            // then some of them are not put into account
            ->withoutGlobalScope(LimitScope::class)
            ->where('iam_user_id', $user->id)
            ->where('iam_account_id', $account->id)
            ->where('is_active', true)
            ->orderBy('level', 'asc')
            ->get();

        return $roles;
    }

    /**
     * This function creates Roles with given AuthorizationRole
     *
     * @param IAuthorizationRole $role
     * @return Roles
     * @throws \Exception
     */
    public static function createRoleFromScope(IAuthorizationRole $role) : Roles
    {
        $Roles = Roles::where('name', $role::NAME)->first();

        if($Roles) {
            return $Roles;
        }

        $data = [
            'name'  =>  $role::NAME,
            'class' =>  get_class($role),
            'level' =>  $role::LEVEL
        ];

        return parent::create($data);
    }

    /**
     * Assigns user to role
     *
     * @param Users $user
     * @param Roles $role
     * @return bool
     */
    public static function assignUserToRole(Users $user, Roles $role, ?Accounts $account = null, $isRoleActive = null) : bool
    {
        //  No one can be a system admin or a system viewer
        if(in_array($role->name, self::NON_ASSIGNABLE_ROLES, true)) {
            return false;
        }

        //  Admin roles are handed out by the platform only (console, run-as-admin, system-admin), leo4#1304
        if(self::isAdminRole($role->name) && !self::mayManageAdminRoles()) {
            Log::warning('[RolesService::assignUserToRole] Refused to assign the admin role ' . $role->name . ' to user ' . $user->uuid);

            return false;
        }

        if(!$account) {
            $account = UserHelper::currentAccount();
        }

        //  Getting the roles of user
        $relation = RoleUsers::withoutGlobalScopes()
            ->where('iam_user_id', $user->id)
            ->where('iam_role_id', $role->id)
            ->where('iam_account_id', $account->id)
            ->first();

        $isActive = true;

        if($isRoleActive !== null) {
            $isActive = $isRoleActive;
        }

        if(!$relation) {
            $relation = RoleUsers::create([
                'iam_user_id'       =>  $user->id,
                'iam_account_id'    =>  $account->id,
                'iam_role_id'       =>  $role->id,
                'is_active'         =>  $isActive
            ]);
        }

        if($isActive) self::setRoleAsActive($relation);

        //  #1303: also give the companion roles in the same account. assignUserToRole() is idempotent,
        //  so assigning again never creates duplicate iam_role_user rows.
        foreach(self::COMPANION_ROLES[$role->name] ?? [] as $companionName) {
            $companion = Roles::withoutGlobalScope(AuthorizationScope::class)
                ->where('name', $companionName)
                ->first();

            if(!$companion) {
                logger()->warning('[RolesService::assignUserToRole] Companion role not found: ' . $companionName);
                continue;
            }

            self::assignUserToRole($user, $companion, $account, $isRoleActive);
        }

        return true;
    }

    /**
     * Grants the co-owner marker role (#1305). Deliberately NOT through assignUserToRole()/the generic role APIs
     * (account-owner is in NON_ASSIGNABLE_ROLES); only AccountsService::addCoOwner() and transferPrimaryOwnership()
     * call this, after their owner checks.
     */
    public static function grantAccountOwnerRole(Users $user, Accounts $account) : void
    {
        $role = self::getRole(new \NextDeveloper\IAM\Authorization\Roles\AccountOwnerRole());

        RoleUsers::withoutGlobalScopes()->firstOrCreate([
            'iam_user_id'    => $user->id,
            'iam_account_id' => $account->id,
            'iam_role_id'    => $role->id,
        ], ['is_active' => true]);
    }

    public static function getUserRole(Users $user, Accounts $account) : Roles
    {
        $role = Cache::get(
            CacheHelper::getKey('Users', $user->uuid, 'CurrentRole')
        );

        if($role) {
            return $role;
        }

        $userRoleRelation = RoleUsers::withoutGlobalScope(AuthorizationScope::class)
            ->where('iam_user_id', $user->id)
            ->where('is_active', 1)
            ->first();

        if(!$userRoleRelation) {
            $role = self::getRole(new MemberRole());

            self::assignUserToRole($user, $role);
        }

        $role = Roles::withoutGlobalScope(AuthorizationScope::class)
            ->where('id', $userRoleRelation->iam_role_id)
            ->first();

        //  If the user don't have any roles, we are creating the Member role for the user
        if(!$role) {
            $role = self::getRole(new MemberRole());

            self::assignUserToRole($user, $role);

            return self::getUserRole($user, $account);
        }

        Cache::set(
            CacheHelper::getKey('Users', $user->uuid, 'CurrentRole'),
            $role
        );

        return $role;
    }

    /**
     * Sets the related UsersRole as active
     *
     * @param RoleUsers $roleUser
     * @return RoleUsers
     */
    public static function setRoleAsActive(RoleUsers $roleUser) : RoleUsers
    {
        /**
         * Here design has changed because we are actively looking for all roles while making security checks.
         * That is why we are not deactivating roles here.
         */

        //  Mark all other roles as not active
//        $roles = RoleUsers::withoutGlobalScopes()
//            ->where('iam_user_id', $roleUser->iam_user_id)
//            ->where('iam_account_id', $roleUser->iam_account_id)
//            ->update([
//                'is_active' =>  0
//            ]);

        //  Update the requested role as active
        RoleUsers::withoutGlobalScopes()
            ->where('iam_user_id', $roleUser->iam_user_id)
            ->where('iam_account_id', $roleUser->iam_account_id)
            ->where('iam_role_id', $roleUser->iam_role_id)
            ->update([
                'is_active' =>  1
            ]);

        //  Get the relation again
        $roleUser = RoleUsers::withoutGlobalScopes()
            ->where('iam_user_id', $roleUser->iam_user_id)
            ->where('iam_account_id', $roleUser->iam_account_id)
            ->where('iam_role_id', $roleUser->iam_role_id)
            ->first();

        return $roleUser;
    }

    public static function setRoleAsActiveById($RolesId, Users $user, Accounts $account) : RoleUsers
    {
        $role = Roles::where('uuid', $RolesId)->first();

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

        //  Get the relation again
        $roles = RoleUsers::where('iam_user_id', $user->id)
            ->where('iam_account_id', $account->id)
            ->where('iam_role_id', $role->id)
            ->first();

        return $roles;
    }
}
