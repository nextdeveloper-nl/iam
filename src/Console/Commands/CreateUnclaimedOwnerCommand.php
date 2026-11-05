<?php

namespace NextDeveloper\IAM\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use NextDeveloper\IAM\Services\UsersService;

/**
 * Creates the non-login placeholder user that owns unclaimed accounts (see
 * AccountsService::getUnclaimedOwner()) and prints its UUID for IAM_UNCLAIMED_OWNER_ID.
 * The placeholder uses a random, undeliverable .invalid address and has no password. The address is
 * random because createWithoutAccount() returns any existing user with the same email, so a fixed
 * address could resolve to a user someone else registered beforehand.
 */
class CreateUnclaimedOwnerCommand extends Command
{
    protected $signature = 'iam:create-unclaimed-owner';

    protected $description = 'Create the placeholder user that owns unclaimed accounts and print its UUID';

    public function handle(): int
    {
        // Unguessable address: guarantees a brand new row, never an existing user.
        $user = UsersService::createWithoutAccount([
            'name'  => 'Unclaimed leads',
            'email' => 'unclaimed-' . Str::lower(Str::random(24)) . '@plusclouds.invalid',
        ]);

        // The placeholder must start with no memberships.
        if (DB::table('iam_account_user')->where('iam_user_id', $user->id)->exists()) {
            $this->error('Placeholder user unexpectedly has account memberships. Aborting.');

            return self::FAILURE;
        }

        $this->info('Set IAM_UNCLAIMED_OWNER_ID=' . $user->uuid);

        return self::SUCCESS;
    }
}
