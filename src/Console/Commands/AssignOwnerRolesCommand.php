<?php

namespace NextDeveloper\IAM\Console\Commands;

use Illuminate\Console\Command;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Models\RoleUsers;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Services\RolesService;

/**
 * Backfills leo.register.owner_roles for existing account owners. New owners get these roles at
 * registration and on account switch (RolesService::assignOwnerRoles); this covers the ones that
 * existed before that was introduced.
 *
 * Re-runs are cheap: the owner roles are resolved once, and one query per chunk finds the owners that
 * already hold every owner role in their own account. Those are skipped without any further queries,
 * so only owners that are actually missing a role are processed (acts as the "once per account" flag
 * without needing a flag column).
 */
class AssignOwnerRolesCommand extends Command
{
    protected $signature = 'iam:assign-owner-roles
                            {--account= : Only process the account with this id}
                            {--dry-run : List the owners that would be processed without assigning anything}';

    protected $description = 'Assign leo.register.owner_roles to the owners of existing accounts';

    public function handle(): int
    {
        if (!config('leo.register.owner_roles')) {
            $this->warn('leo.register.owner_roles is empty, nothing to assign.');

            return self::SUCCESS;
        }

        $query = Accounts::withoutGlobalScopes()->whereNotNull('iam_user_id');

        if ($this->option('account')) {
            $query->where('id', $this->option('account'));
        }

        //  Resolve the owner roles once instead of once per owner. Roles that do not exist are ignored here;
        //  assignOwnerRoles() logs them when it runs.
        $roleIds = [];
        foreach (config('leo.register.owner_roles') as $roleName) {
            $role = RolesService::getRoleByName($roleName);

            if ($role) {
                $roleIds[] = $role->id;
            }
        }

        $processed = 0;
        $skipped = 0;
        $alreadyDone = 0;

        $query->chunkById(200, function ($accounts) use (&$processed, &$skipped, &$alreadyDone, $roleIds) {
            //  One query for the whole chunk: how many of the owner roles each (account, owner) pair already has
            $held = RoleUsers::withoutGlobalScopes()
                ->whereIn('iam_account_id', $accounts->pluck('id'))
                ->whereIn('iam_user_id', $accounts->pluck('iam_user_id')->unique())
                ->whereIn('iam_role_id', $roleIds)
                ->selectRaw('iam_account_id, iam_user_id, count(distinct iam_role_id) as roles')
                ->groupBy('iam_account_id', 'iam_user_id')
                ->get()
                ->mapWithKeys(fn ($row) => [$row->iam_account_id . ':' . $row->iam_user_id => (int) $row->roles]);

            foreach ($accounts as $account) {
                //  Owner already has every owner role in this account, nothing to do
                if ($roleIds && ($held[$account->id . ':' . $account->iam_user_id] ?? 0) >= count($roleIds)) {
                    $alreadyDone++;
                    continue;
                }

                $owner = Users::withoutGlobalScopes()->where('id', $account->iam_user_id)->first();

                if (!$owner) {
                    $skipped++;
                    continue;
                }

                if ($this->option('dry-run')) {
                    $this->line('Would assign owner roles: account ' . $account->id . ' / user ' . $owner->id);
                } else {
                    //  Idempotent: existing user-role relations are not duplicated
                    RolesService::assignOwnerRoles($owner, $account);
                }

                $processed++;
            }
        });

        $this->info(($this->option('dry-run') ? 'Dry run: ' : '') . $processed . ' owners processed, ' . $alreadyDone . ' already had all owner roles, ' . $skipped . ' skipped (owner user not found).');

        return self::SUCCESS;
    }
}
