<?php

namespace NextDeveloper\IAM\Services;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use NextDeveloper\Commons\Services\CommandLogsService;
use NextDeveloper\IAM\Authorization\Roles\MemberRole;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Models\AccountUsers;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Exceptions\UnauthorizedException;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\Authentication\AccessTokenService;
use NextDeveloper\IAM\Services\Authentication\OAuthService;

/**
 * AI (robot) assistant users (#1306). A real iam_users row (can own records, be assigned work, appear in member
 * lists) that can never sign in by itself: there is no password or login mechanism, and OAuthService /
 * AccessTokenService refuse any assistant session that was not created by switchTo(). A human user can have
 * several assistants, one per purpose.
 *
 * Who may switch into an assistant: its owner, or an owner of an account the assistant's owner is a member of
 * (a co-owner can not switch into the primary owner's assistants). Assistants only ever hold the member role, so
 * they can never exceed their owner's roles.
 */
class AiAssistantsService
{
    public const MAX_PER_OWNER = 10;

    /** Domain of the synthetic, never-deliverable address of assistants. */
    public const EMAIL_DOMAIN = 'assistants.invalid';

    /**
     * Assistants the actor may use: their own, plus the assistants of members of accounts the actor owns.
     */
    public static function listFor(Users $actor, ?Accounts $account = null): \Illuminate\Support\Collection
    {
        self::assertColumnsExist();

        $ownerIds = [$actor->id];
        $account = $account ?: UserHelper::currentAccount();

        if ($account && UserHelper::isAccountOwner($actor, $account)) {
            $memberIds = AccountUsers::withoutGlobalScopes()->where('iam_account_id', $account->id)->pluck('iam_user_id')->all();

            foreach ($memberIds as $memberId) {
                if (self::mayUseAssistantsOf($actor, $memberId, $account)) {
                    $ownerIds[] = $memberId;
                }
            }
        }

        return Users::withoutGlobalScopes()
            ->where('is_ai_assistant', true)
            ->whereIn('owner_iam_user_id', array_unique($ownerIds))
            ->orderBy('id')
            ->get();
    }

    /**
     * Creates an assistant for the owner (the actor) for a purpose, in every account the owner belongs to.
     *
     * @throws UnauthorizedException
     */
    public static function create(Users $owner, string $purpose, ?string $name = null): Users
    {
        self::assertColumnsExist();

        if ($owner->isAiAssistant()) {
            throw new UnauthorizedException('An AI assistant can not own assistants.');
        }

        $purpose = Str::slug($purpose);

        if ($purpose === '') {
            throw new UnauthorizedException('A purpose is required.');
        }

        $existing = Users::withoutGlobalScopes()->where('is_ai_assistant', true)->where('owner_iam_user_id', $owner->id);

        if ((clone $existing)->where('ai_assistant_purpose', $purpose)->exists()) {
            throw new UnauthorizedException('You already have an assistant for this purpose.');
        }

        if ((clone $existing)->count() >= self::MAX_PER_OWNER) {
            throw new UnauthorizedException('You can have at most '.self::MAX_PER_OWNER.' AI assistants.');
        }

        $label = $name ?: trim(($owner->name ?: 'My').' AI assistant ('.$purpose.')');

        $assistant = UserHelper::runAsAdmin(fn () => UsersService::createWithoutAccount([
            'name' => $label,
            'surname' => '',
            'email' => 'assistant-'.Str::uuid().'@'.self::EMAIL_DOMAIN,
            'is_ai_assistant' => true,
            'owner_iam_user_id' => $owner->id,
            'ai_assistant_purpose' => $purpose,
            'is_active' => true,
        ]));

        // Member of the same accounts as the owner, with the member role only (never above the owner's roles)
        $memberRole = RolesService::getRole(new MemberRole());
        $accountIds = AccountUsers::withoutGlobalScopes()->where('iam_user_id', $owner->id)->pluck('iam_account_id');

        foreach (Accounts::withoutGlobalScopes()->whereIn('id', $accountIds)->get() as $account) {
            AccountUsers::withoutGlobalScopes()->firstOrCreate(
                ['iam_user_id' => $assistant->id, 'iam_account_id' => $account->id],
                ['is_active' => true]
            );

            RolesService::assignUserToRole($assistant, $memberRole, $account);
        }

        return $assistant;
    }

    /**
     * Auth code that lets the panel sign in as the assistant. Strict check: the actor must be allowed
     * (canSwitch). Audited with both ids.
     *
     * @throws UnauthorizedException
     */
    public static function switchTo(Users $actor, string $assistantUuid, ?string $clientId, string $redirectUri): string
    {
        self::assertColumnsExist();

        $assistant = Users::withoutGlobalScopes()->where('uuid', $assistantUuid)->where('is_ai_assistant', true)->first();

        if (! $assistant || ! self::canSwitch($actor, $assistant)) {
            throw new UnauthorizedException('You can not switch to this assistant.');
        }

        $session = OAuthService::createSession($clientId, $redirectUri);

        if (! $session) {
            throw new UnauthorizedException('Invalid client or redirect.');
        }

        OAuthService::setOwnerSwitchValidated($session, $assistant, $actor);

        $code = OAuthService::getAuthCode($session, []);

        if (! $code) {
            throw new UnauthorizedException('Could not issue a sign-in code.');
        }

        CommandLogsService::record([
            'module' => 'iam',
            'action' => 'switch-to-ai-assistant',
            'operation' => 'system',
            'resource' => 'iam_users',
            'object_type' => 'NextDeveloper\IAM\Users',
            'object_id' => $assistant->uuid,
            'context' => [
                'owner_iam_user_id' => $assistant->owner_iam_user_id,
                'switched_by' => $actor->uuid,
                'assistant' => $assistant->uuid,
            ],
        ]);

        return $code;
    }

    /**
     * Returns from the assistant to the user who switched in (#1306): a one-time auth code for that user. The
     * caller is the assistant (identified by its current token). Who switched is read from the token, so a
     * shared-account owner who switched into a member's assistant returns to themselves, never to the member.
     * The assistant token is revoked. Refuses when the token was not issued by a switch, or when the user may no
     * longer switch to this assistant.
     *
     * @throws UnauthorizedException
     */
    public static function switchBack(Users $assistant, ?string $tokenId, ?string $clientId, string $redirectUri): string
    {
        self::assertColumnsExist();

        if (! $assistant->isAiAssistant() || ! $tokenId) {
            throw new UnauthorizedException('You are not acting as an AI assistant.');
        }

        $name = \DB::table('oauth_access_tokens')->where('id', $tokenId)->where('user_id', $assistant->id)->value('name');

        if (! is_string($name) || ! str_starts_with($name, AccessTokenService::SWITCH_TOKEN_PREFIX)) {
            throw new UnauthorizedException('This session was not started by switching from a user.');
        }

        $actor = Users::withoutGlobalScopes()->where('id', (int) substr($name, strlen(AccessTokenService::SWITCH_TOKEN_PREFIX)))->first();

        if (! $actor || $actor->isAiAssistant() || ! self::canSwitch($actor, $assistant)) {
            throw new UnauthorizedException('You can not switch back to this user.');
        }

        $session = OAuthService::createSession($clientId, $redirectUri);

        if (! $session) {
            throw new UnauthorizedException('Invalid client or redirect.');
        }

        OAuthService::setSwitchBackValidated($session, $actor, $assistant);

        $code = OAuthService::getAuthCode($session, []);

        if (! $code) {
            throw new UnauthorizedException('Could not issue a sign-in code.');
        }

        // The assistant session ends here
        \DB::table('oauth_access_tokens')->where('id', $tokenId)->delete();

        CommandLogsService::record([
            'module' => 'iam',
            'action' => 'switch-back-from-ai-assistant',
            'operation' => 'system',
            'resource' => 'iam_users',
            'object_type' => 'NextDeveloper\IAM\Users',
            'object_id' => $assistant->uuid,
            'context' => [
                'owner_iam_user_id' => $assistant->owner_iam_user_id,
                'switched_back_to' => $actor->uuid,
                'assistant' => $assistant->uuid,
            ],
        ]);

        return $code;
    }

    /**
     * Who the current session is, for the panel banner (#1306): whether the caller is an AI assistant, its owner
     * and who switched in (read from the token).
     *
     * @return array{is_ai_assistant: bool, assistant?: array, owner_id?: ?string, switched_by_id?: ?string}
     */
    public static function status(Users $me, ?string $tokenId): array
    {
        if (! $me->isAiAssistant()) {
            return ['is_ai_assistant' => false];
        }

        $name = $tokenId ? \DB::table('oauth_access_tokens')->where('id', $tokenId)->where('user_id', $me->id)->value('name') : null;
        $switchedById = is_string($name) && str_starts_with($name, AccessTokenService::SWITCH_TOKEN_PREFIX)
            ? (int) substr($name, strlen(AccessTokenService::SWITCH_TOKEN_PREFIX))
            : null;

        return [
            'is_ai_assistant' => true,
            'assistant' => ['id' => $me->uuid, 'name' => $me->name, 'purpose' => $me->ai_assistant_purpose],
            'owner_id' => Users::withoutGlobalScopes()->where('id', $me->owner_iam_user_id)->value('uuid'),
            'switched_by_id' => $switchedById ? Users::withoutGlobalScopes()->where('id', $switchedById)->value('uuid') : null,
        ];
    }

    /**
     * The owner may always switch; an owner of a shared account may too, except a co-owner into the primary
     * owner's assistants.
     */
    public static function canSwitch(Users $actor, Users $assistant): bool
    {
        if (! $assistant->isAiAssistant() || $actor->isAiAssistant() || $actor->id === $assistant->id) {
            return false;
        }

        if ($assistant->owner_iam_user_id === $actor->id) {
            return true;
        }

        $sharedAccountIds = AccountUsers::withoutGlobalScopes()
            ->where('iam_user_id', $assistant->owner_iam_user_id)
            ->whereIn('iam_account_id', AccountUsers::withoutGlobalScopes()->where('iam_user_id', $actor->id)->select('iam_account_id'))
            ->pluck('iam_account_id');

        foreach (Accounts::withoutGlobalScopes()->whereIn('id', $sharedAccountIds)->get() as $account) {
            if (self::mayUseAssistantsOf($actor, $assistant->owner_iam_user_id, $account)) {
                return true;
            }
        }

        return false;
    }

    private static function mayUseAssistantsOf(Users $actor, int $ownerId, Accounts $account): bool
    {
        if ($ownerId === $actor->id) {
            return true;
        }

        if (! UserHelper::isAccountOwner($actor, $account)) {
            return false;
        }

        // A co-owner must not use the primary owner's assistants (same takeover guard as for credentials)
        return $ownerId !== $account->iam_user_id || UserHelper::isPrimaryOwner($actor, $account);
    }

    private static function assertColumnsExist(): void
    {
        if (! Schema::hasColumn('iam_users', 'is_ai_assistant')) {
            throw new UnauthorizedException('AI assistants are not available yet (database not updated).');
        }
    }
}
