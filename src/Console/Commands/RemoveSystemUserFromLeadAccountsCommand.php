<?php

namespace NextDeveloper\IAM\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Helpers\UserHelper;

/**
 * Cleans up LeadOcean accounts that were created while the Leo system user was the acting user.
 * AccountsService::create() made Leo the owner and a member of every lead account without a
 * usable email. This removes Leo's membership from those accounts and clears Leo as owner.
 *
 * Only accounts tagged LeadOcean are touched, and only where Leo is not the active member, so
 * Leo's own working account is never affected.
 */
class RemoveSystemUserFromLeadAccountsCommand extends Command
{
    protected $signature = 'iam:remove-system-user-from-lead-accounts
                            {--tag=LeadOcean : Only process accounts carrying this tag}
                            {--dry-run : Report what would change without changing anything}';

    protected $description = 'Remove the Leo system user as owner/member from LeadOcean-tagged accounts';

    public function handle(): int
    {
        $leo    = UserHelper::getLeoOwner();
        $dryRun = (bool) $this->option('dry-run');
        $tag    = $this->option('tag');

        if (! $leo) {
            $this->error('Leo system user not found.');

            return self::FAILURE;
        }

        $membershipsRemoved = 0;
        $ownersCleared      = 0;

        // Accounts where Leo is only an inactive member (his own account is the active one)
        // or where Leo is stamped as owner.
        $query = Accounts::withoutGlobalScopes()
            ->whereRaw('tags @> ARRAY[?]::text[]', [$tag])
            ->where(function ($q) use ($leo) {
                $q->where('iam_user_id', $leo->id)
                    ->orWhereIn('id', function ($sub) use ($leo) {
                        $sub->select('iam_account_id')
                            ->from('iam_account_user')
                            ->where('iam_user_id', $leo->id)
                            ->where('is_active', false);
                    });
            });

        $query->chunkById(500, function ($accounts) use ($leo, $dryRun, &$membershipsRemoved, &$ownersCleared) {
            foreach ($accounts as $account) {
                // Never touch the account Leo actively works in.
                $isActiveForLeo = DB::table('iam_account_user')
                    ->where('iam_account_id', $account->id)
                    ->where('iam_user_id', $leo->id)
                    ->where('is_active', true)
                    ->exists();

                if ($isActiveForLeo) {
                    continue;
                }

                $memberships = DB::table('iam_account_user')
                    ->where('iam_account_id', $account->id)
                    ->where('iam_user_id', $leo->id);

                $membershipsRemoved += $memberships->count();

                if ($account->iam_user_id == $leo->id) {
                    $ownersCleared++;
                }

                if ($dryRun) {
                    continue;
                }

                $memberships->delete();

                if ($account->iam_user_id == $leo->id) {
                    // Fall back to the first remaining real member, otherwise leave ownerless.
                    $newOwner = DB::table('iam_account_user')
                        ->where('iam_account_id', $account->id)
                        ->orderBy('id')
                        ->value('iam_user_id');

                    Accounts::withoutGlobalScopes()
                        ->where('id', $account->id)
                        ->update(['iam_user_id' => $newOwner]);
                }
            }
        });

        $this->info(sprintf(
            '%s: %d membership(s) removed, %d owner(s) cleared.',
            $dryRun ? 'Dry run' : 'Done',
            $membershipsRemoved,
            $ownersCleared
        ));

        return self::SUCCESS;
    }
}
