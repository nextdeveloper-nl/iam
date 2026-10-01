<?php

namespace NextDeveloper\IAM\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use NextDeveloper\IAM\AuthenticationGrants\Password;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Services\Authentication\PasswordService;

class GeneratePasswordsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iam:generate-passwords
                            {--output= : CSV file to write the generated passwords to (default: storage/app/passwords-<date>.csv)}
                            {--account= : Only users of this account (id)}
                            {--all : Also replace the password of users who already have one}
                            {--dry-run : Only list the users that would get a password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates sign in passwords for users and writes them to a CSV file for distribution';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $query = Users::withoutGlobalScope(AuthorizationScope::class)
            ->whereNull('deleted_at')
            ->orderBy('id');

        if ($accountId = $this->option('account')) {
            $query->whereIn('id', DB::table('iam_account_user')
                ->where('iam_account_id', $accountId)
                ->select('iam_user_id'));
        }

        $users = $query->get()->filter(fn (Users $user) => $this->option('all') || !Password::hasPassword($user));

        if ($users->isEmpty()) {
            $this->info('No users need a password.');

            return self::SUCCESS;
        }

        if ($this->option('dry-run')) {
            $this->table(['id', 'email', 'username'], $users->map(fn ($u) => [$u->id, $u->email, $u->username])->all());
            $this->info($users->count() . ' user(s) would get a password.');

            return self::SUCCESS;
        }

        if ($this->option('all') && !$this->confirm('This replaces the password of every selected user and signs them out. Continue?')) {
            return self::FAILURE;
        }

        $output = $this->option('output') ?: storage_path('app/passwords-' . now()->format('Y-m-d-His') . '.csv');

        $handle = @fopen($output, 'x');

        if (!$handle) {
            $this->error('Cannot create ' . $output . ' (it may already exist).');

            return self::FAILURE;
        }

        //  The file holds plain passwords, so only the owner may read it.
        @chmod($output, 0600);

        fputcsv($handle, ['email', 'username', 'password']);

        foreach ($users as $user) {
            $password = PasswordService::setPassword($user);

            fputcsv($handle, [$user->email, $user->username, $password]);
        }

        fclose($handle);

        $this->info('Generated passwords for ' . $users->count() . ' user(s): ' . $output);
        $this->warn('This file contains plain passwords. Hand them out securely and delete the file afterwards.');

        return self::SUCCESS;
    }
}
