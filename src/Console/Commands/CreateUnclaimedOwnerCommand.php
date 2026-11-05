<?php

namespace NextDeveloper\IAM\Console\Commands;

use Illuminate\Console\Command;
use NextDeveloper\IAM\Services\UsersService;

/**
 * Creates the non-login placeholder user that owns unclaimed accounts (see
 * AccountsService::getUnclaimedOwner()) and prints its UUID for IAM_UNCLAIMED_OWNER_ID.
 * The placeholder uses an undeliverable .invalid address and has no password.
 */
class CreateUnclaimedOwnerCommand extends Command
{
    protected $signature = 'iam:create-unclaimed-owner';

    protected $description = 'Create the placeholder user that owns unclaimed accounts and print its UUID';

    public function handle(): int
    {
        $user = UsersService::createWithoutAccount([
            'name'  => 'Unclaimed leads',
            'email' => 'unclaimed-leads@plusclouds.invalid',
        ]);

        $this->info('Set IAM_UNCLAIMED_OWNER_ID=' . $user->uuid);

        return self::SUCCESS;
    }
}
