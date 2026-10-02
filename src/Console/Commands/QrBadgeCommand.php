<?php

namespace NextDeveloper\IAM\Console\Commands;

use Illuminate\Console\Command;
use NextDeveloper\IAM\AuthenticationGrants\QrBadge;
use NextDeveloper\IAM\Helpers\UserHelper;

class QrBadgeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iam:qr-badge
                            {identifier : E-mail address or username of the user}
                            {--revoke : Remove the user\'s badge instead of issuing one}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Issues (or revokes) a QR sign-in badge for a user and prints its QR content once';

    public function handle(): int
    {
        $identifier = $this->argument('identifier');

        $user = UserHelper::getWithEmail($identifier) ?? UserHelper::getWithUsername($identifier);

        if (!$user) {
            $this->error('No user found with e-mail or username: ' . $identifier);

            return self::FAILURE;
        }

        if ($this->option('revoke')) {
            $this->info(QrBadge::revoke($user) ? 'Badge revoked for ' . $user->email . '.' : $user->email . ' has no badge.');

            return self::SUCCESS;
        }

        $content = QrBadge::issue($user);

        $this->info('Badge issued for ' . $user->email . '. Any previous badge no longer works.');
        $this->line('QR content (encode this in the QR code; it is not stored and cannot be shown again):');
        $this->line($content);

        return self::SUCCESS;
    }
}
