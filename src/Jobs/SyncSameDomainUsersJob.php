<?php

namespace NextDeveloper\IAM\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NextDeveloper\Commons\Database\Models\Domains;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Models\AccountUsers;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;

/**
 * Attaches every user whose email domain matches the account's domain as an active
 * member. Runs when same-domain join is activated or a domain is newly set. When the
 * feature is disabled (deactivate) it is a no-op, so existing members are never removed.
 */
class SyncSameDomainUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Accounts $account, private array $params = []) {}

    public function handle(): void
    {
        if (! $this->account->allow_same_domain_join || ! $this->account->common_domain_id) {
            return;
        }

        $domain = Domains::withoutGlobalScope(AuthorizationScope::class)
            ->where('id', $this->account->common_domain_id)
            ->first();

        if (! $domain) {
            return;
        }

        $users = Users::withoutGlobalScope(AuthorizationScope::class)
            ->where('email', 'ilike', '%@'.$domain->name)
            ->get();

        foreach ($users as $user) {
            AccountUsers::withoutGlobalScopes()->updateOrCreate(
                [
                    'iam_user_id' => $user->id,
                    'iam_account_id' => $this->account->id,
                ],
                [
                    'is_active' => true,
                ]
            );
        }
    }
}
