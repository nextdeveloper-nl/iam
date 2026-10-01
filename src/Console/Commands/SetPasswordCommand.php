<?php

namespace NextDeveloper\IAM\Console\Commands;

use Illuminate\Console\Command;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\Authentication\PasswordService;

class SetPasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iam:set-password
                            {identifier : E-mail address or username of the user}
                            {--password= : The new password; asked for when left out}
                            {--generate : Generate a password and print it}
                            {--keep-tokens : Do not sign the user out of existing sessions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets the sign in password of a user, so the user can sign in with username/e-mail and password';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $identifier = $this->argument('identifier');

        $user = UserHelper::getWithEmail($identifier) ?? UserHelper::getWithUsername($identifier);

        if (!$user) {
            $this->error('No user found with e-mail or username: ' . $identifier);

            return self::FAILURE;
        }

        $password = null;

        if (!$this->option('generate')) {
            $password = $this->option('password') ?: $this->secret('New password (min 8 characters)');

            if (!is_string($password) || strlen($password) < 8) {
                $this->error('The password has to be at least 8 characters.');

                return self::FAILURE;
            }
        }

        $password = PasswordService::setPassword($user, $password, !$this->option('keep-tokens'));

        $this->info('Password set for ' . $user->email . ($user->username ? ' (' . $user->username . ')' : '') . '.');

        if ($this->option('generate')) {
            $this->line('Generated password: ' . $password);
        }

        return self::SUCCESS;
    }
}
