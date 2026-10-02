<?php

namespace NextDeveloper\IAM\Console\Commands;

use Illuminate\Console\Command;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Services\RolesService;

/**
 * Backfills leo.register.owner_roles for existing account owners. New owners get these roles at
 * registration and on account switch (RolesService::assignOwnerRoles); this covers the ones that
 * existed before that was introduced.
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

        $processed = 0;
        $skipped = 0;

        $query->chunkById(200, function ($accounts) use (&$processed, &$skipped) {
            foreach ($accounts as $account) {
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

        $this->info(($this->option('dry-run') ? 'Dry run: ' : '') . $processed . ' owners processed, ' . $skipped . ' skipped (owner user not found).');

        return self::SUCCESS;
    }
}
