<?php

namespace NextDeveloper\IAM\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;

class RefreshTokenCommand extends Command
{
    /**
     * The supported OAuth providers
     */
    private const SUPPORTED_PROVIDERS = [
        'google'        => 'GoogleLogin',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iam:refresh-token {provider}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh OAuth tokens for the specified provider';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            $provider = strtolower($this->argument('provider'));

            if (!$this->validateProvider($provider)) {
                return 1;
            }

            $this->info("Starting token refresh for {$provider}");

            $count = $this->refreshTokens($provider);

            $this->info("Successfully refreshed {$count} tokens for {$provider}");
            return 0;

        } catch (Exception $e) {
            $this->error("An error occurred: {$e->getMessage()}");
            Log::error('[IAM::Console/Command::Token refresh failed]', [
                'provider'  => $provider ?? 'unknown',
                'error'     => $e->getMessage(),
                'trace'     => $e->getTraceAsString()
            ]);
            return 1;
        }
    }

    /**
     * Validate the provider
     *
     * @param string $provider
     * @return bool
     */
    private function validateProvider(string $provider): bool
    {
        if (!array_key_exists($provider, self::SUPPORTED_PROVIDERS)) {
            $supported = implode(', ', array_keys(self::SUPPORTED_PROVIDERS));
            $this->error("Provider '{$provider}' is not supported. Supported providers: {$supported}");
            return false;
        }
        return true;
    }

    /**
     * Refresh tokens for the specified provider, only for the latest mechanism per user
     *
     * @param string $provider
     * @return int
     */
    private function refreshTokens(string $provider): int
    {
        $count = 0;
        $loginMechanism = self::SUPPORTED_PROVIDERS[$provider];

        // Subquery to get the latest login mechanism ID for each user
        $latestMechanisms = LoginMechanisms::withoutGlobalScope(AuthorizationScope::class)
            ->select('id')
            ->whereIn('id', function ($query) use ($loginMechanism) {
                $query->select(\DB::raw('MAX(id)'))
                    ->from('iam_login_mechanisms')
                    ->where('login_mechanism', $loginMechanism)
                    ->where('is_latest', true)
                    ->groupBy('iam_user_id');
            });

        // Get the actual mechanisms
        $mechanisms = LoginMechanisms::withoutGlobalScope(AuthorizationScope::class)
            ->whereIn('id', $latestMechanisms)
            ->get();

        if ($mechanisms->isEmpty()) {
            $this->info("No login mechanisms found for provider: {$provider}");
            return 0;
        }

        $progressBar = $this->output->createProgressBar($mechanisms->count());
        $progressBar->start();

        foreach ($mechanisms as $mechanism) {
            try {
                if ($this->shouldRefreshToken($mechanism)) {
                    $this->refreshToken($provider, $mechanism);
                    $count++;
                }
            } catch (Exception $e) {
                Log::warning("[IAM::Console/Command::Token refresh failed]", [
                    'provider'      => $provider,
                    'user_id'       => $mechanism->iam_user_id,
                    'mechanism_id'  => $mechanism->id,
                    'error'         => $e->getMessage(),
                    'trace'         => $e->getTraceAsString()
                ]);

                // Optionally notify about the failure
                $this->error(sprintf(
                    'Failed to refresh token for user %s: %s',
                    $mechanism->iam_user_id,
                    $e->getMessage()
                ));
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        // Log summary
        Log::info("[IAM::Console/Command::Token refresh completed]", [
            'provider' => $provider,
            'total_processed' => $mechanisms->count(),
            'successfully_refreshed' => $count
        ]);

        return $count;
    }

    /**
     * Check if token should be refreshed
     *
     * @param LoginMechanisms $mechanism
     * @return bool
     */
    private function shouldRefreshToken(LoginMechanisms $mechanism): bool
    {
        $loginData = $mechanism->login_data;

        if (!isset($loginData['token']) || !isset($loginData['refreshToken'])) {
            return false;
        }

        return true;
    }

    /**
     * Refresh token for specific mechanism
     *
     * @param string $provider
     * @param LoginMechanisms $mechanism
     * @throws Exception
     */
    private function refreshToken(string $provider, LoginMechanisms $mechanism): void
    {
        try {
            $loginData = $mechanism->login_data;

            $token = Socialite::driver($provider)
                ->refreshToken($loginData['refreshToken']);

            $mechanism->updateQuietly([
                'login_data' => [
                    'token'             => $token->token,
                    'refreshToken'      => $token->refreshToken ?? $loginData['refreshToken'],
                    'expiresIn'         => now()->addSeconds($token->expiresIn ?? 3600),
                    'last_refreshed'    => now()->toIso8601String(),
                    'scopes'            => $token->approvedScopes ?? '',
                ],
            ]);

        } catch (Exception $e) {
            throw new Exception(
                "Failed to refresh token for provider {$provider}: {$e->getMessage()}",
                0,
                $e
            );
        }
    }
}