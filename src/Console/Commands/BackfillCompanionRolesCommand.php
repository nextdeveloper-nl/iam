<?php

namespace NextDeveloper\IAM\Console\Commands;

use Illuminate\Console\Command;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Models\Roles;
use NextDeveloper\IAM\Database\Models\RoleUsers;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Services\RolesService;

/**
 * Backfills the companion roles (RolesService::COMPANION_ROLES, #1303) for users that already hold the key
 * role in an account but not the companion role in that same account. Always run with --dry-run first.
 */
class BackfillCompanionRolesCommand extends Command
{
    protected $signature = 'iam:backfill-companion-roles
                            {--dry-run : List what would be assigned without assigning anything}';

    protected $description = 'Assign companion roles (e.g. flow-manager for sales-manager) to existing role holders';

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');
        $total = 0;

        foreach (RolesService::COMPANION_ROLES as $keyName => $companionNames) {
            $key = Roles::withoutGlobalScopes()->where('name', $keyName)->first();

            if (!$key) {
                continue;
            }

            foreach ($companionNames as $companionName) {
                $companion = Roles::withoutGlobalScopes()->where('name', $companionName)->first();

                if (!$companion) {
                    $this->warn("Companion role {$companionName} does not exist, skipped.");
                    continue;
                }

                //  Key-role rows that have no companion row in the same account for the same user
                $missing = RoleUsers::withoutGlobalScopes()
                    ->where('iam_role_id', $key->id)
                    ->whereNotExists(function ($q) use ($companion) {
                        $q->select(\DB::raw(1))
                            ->from('iam_role_user as c')
                            ->whereColumn('c.iam_user_id', 'iam_role_user.iam_user_id')
                            ->whereColumn('c.iam_account_id', 'iam_role_user.iam_account_id')
                            ->where('c.iam_role_id', $companion->id);
                    })
                    ->get();

                foreach ($missing as $row) {
                    $this->line(($dry ? '[dry-run] ' : '') . "{$keyName} -> {$companionName}: user {$row->iam_user_id}, account {$row->iam_account_id}");

                    if (!$dry) {
                        $user = Users::withoutGlobalScopes()->find($row->iam_user_id);
                        $account = Accounts::withoutGlobalScopes()->find($row->iam_account_id);

                        if ($user && $account) {
                            RolesService::assignUserToRole($user, $companion, $account);
                        }
                    }

                    $total++;
                }
            }
        }

        $this->info(($dry ? 'Would assign ' : 'Assigned ') . $total . ' companion role(s).');

        return self::SUCCESS;
    }
}
