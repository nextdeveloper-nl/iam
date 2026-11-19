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
 * AI (robot) agent users (#1306). A real iam_users row (can own records, be assigned work, appear in member
 * lists) that can never sign in by itself: there is no password or login mechanism, and OAuthService /
 * AccessTokenService refuse any agent session that was not created by switchTo(). A human user can have
 * several agents, one per purpose.
 *
 * Who may switch into an agent: its owner, or an owner of an account the agent's owner is a member of
 * (a co-owner can not switch into the primary owner's agents). Agents only ever hold the member role, so
 * they can never exceed their owner's roles.
 */
class AiAgentsService
{
    public const MAX_PER_OWNER = 10;

    /** Domain of the synthetic, never-deliverable address of agents. */
    public const EMAIL_DOMAIN = 'agents.invalid';

    /**
     * Agents the actor may use: their own, plus the agents of members of accounts the actor owns.
     */
    public static function listFor(Users $actor, ?Accounts $account = null): \Illuminate\Support\Collection
    {
        self::assertColumnsExist();

        $ownerIds = [$actor->id];
        $account = $account ?: UserHelper::currentAccount();

        if ($account && UserHelper::isAccountOwner($actor, $account)) {
            $memberIds = AccountUsers::withoutGlobalScopes()->where('iam_account_id', $account->id)->pluck('iam_user_id')->all();

            foreach ($memberIds as $memberId) {
                if (self::mayUseAgentsOf($actor, $memberId, $account)) {
                    $ownerIds[] = $memberId;
                }
            }
        }

        return Users::withoutGlobalScopes()
            ->where(self::flagColumn(), true)
            ->whereIn('owner_iam_user_id', array_unique($ownerIds))
            ->orderBy('id')
            ->get();
    }

    /**
     * Creates an agent for the owner (the actor) for a purpose, in every account the owner belongs to.
     *
     * @throws UnauthorizedException
     */
    public static function create(Users $owner, string $purpose, ?string $name = null): Users
    {
        self::assertColumnsExist();

        if ($owner->isAiAgent()) {
            throw new UnauthorizedException('An AI agent can not own agents.');
        }

        $purpose = Str::slug($purpose);

        if ($purpose === '') {
            throw new UnauthorizedException('A purpose is required.');
        }

        $existing = Users::withoutGlobalScopes()->where(self::flagColumn(), true)->where('owner_iam_user_id', $owner->id);

        if ((clone $existing)->where(self::purposeColumn(), $purpose)->exists()) {
            throw new UnauthorizedException('You already have an agent for this purpose.');
        }

        if ((clone $existing)->count() >= self::MAX_PER_OWNER) {
            throw new UnauthorizedException('You can have at most '.self::MAX_PER_OWNER.' AI agents.');
        }

        $label = $name ?: trim(($owner->name ?: 'My').' AI agent ('.$purpose.')');

        $agent = UserHelper::runAsAdmin(fn () => UsersService::createWithoutAccount([
            'name' => $label,
            'surname' => '',
            'email' => 'agent-'.Str::uuid().'@'.self::EMAIL_DOMAIN,
            self::flagColumn() => true,
            'owner_iam_user_id' => $owner->id,
            self::purposeColumn() => $purpose,
            'is_active' => true,
        ]));

        // Member of the same accounts as the owner, with the member role only (never above the owner's roles)
        $memberRole = RolesService::getRole(new MemberRole());
        $accountIds = AccountUsers::withoutGlobalScopes()->where('iam_user_id', $owner->id)->pluck('iam_account_id');

        foreach (Accounts::withoutGlobalScopes()->whereIn('id', $accountIds)->get() as $account) {
            AccountUsers::withoutGlobalScopes()->firstOrCreate(
                ['iam_user_id' => $agent->id, 'iam_account_id' => $account->id],
                ['is_active' => true]
            );

            RolesService::assignUserToRole($agent, $memberRole, $account);
        }

        return $agent;
    }

    /**
     * Auth code that lets the panel sign in as the agent. Strict check: the actor must be allowed
     * (canSwitch). Audited with both ids.
     *
     * @throws UnauthorizedException
     */
    public static function switchTo(Users $actor, string $agentUuid, ?string $clientId, string $redirectUri, ?string $actorTokenId = null): string
    {
        self::assertColumnsExist();

        $agent = Users::withoutGlobalScopes()->where('uuid', $agentUuid)->where(self::flagColumn(), true)->first();

        if (! $agent || ! self::canSwitch($actor, $agent)) {
            throw new UnauthorizedException('You can not switch to this agent.');
        }

        $session = OAuthService::createSession($clientId, $redirectUri);

        if (! $session) {
            throw new UnauthorizedException('Invalid client or redirect.');
        }

        OAuthService::setOwnerSwitchValidated($session, $agent, $actor, $actorTokenId);

        $code = OAuthService::getAuthCode($session, []);

        if (! $code) {
            throw new UnauthorizedException('Could not issue a sign-in code.');
        }

        CommandLogsService::record([
            'module' => 'iam',
            'action' => 'switch-to-ai-agent',
            'operation' => 'system',
            'resource' => 'iam_users',
            'object_type' => 'NextDeveloper\IAM\Users',
            'object_id' => $agent->uuid,
            'context' => [
                'owner_iam_user_id' => $agent->owner_iam_user_id,
                'switched_by' => $actor->uuid,
                'agent' => $agent->uuid,
            ],
        ]);

        return $code;
    }

    /**
     * Returns from the agent to the user who switched in (#1306): a one-time auth code for that user. The
     * caller is the agent (identified by its current token). Who switched is read from the token, so a
     * shared-account owner who switched into a member's agent returns to themselves, never to the member.
     * The agent token is revoked. Refuses when the token was not issued by a switch, or when the user may no
     * longer switch to this agent.
     *
     * @throws UnauthorizedException
     */
    public static function switchBack(Users $agent, ?string $tokenId, ?string $clientId, string $redirectUri): string
    {
        self::assertColumnsExist();

        if (! $agent->isAiAgent() || ! $tokenId) {
            throw new UnauthorizedException('You are not acting as an AI agent.');
        }

        $name = \DB::table('oauth_access_tokens')->where('id', $tokenId)->where('user_id', $agent->id)->value('name');

        if (! is_string($name) || ! str_starts_with($name, AccessTokenService::SWITCH_TOKEN_PREFIX)) {
            throw new UnauthorizedException('This session was not started by switching from a user.');
        }

        [$actorId, $actorTokenId] = array_pad(explode(':', substr($name, strlen(AccessTokenService::SWITCH_TOKEN_PREFIX)), 2), 2, '');

        // Tied to the session the user switched with: once that token is gone (logout, password change, revoked) or
        // expired, the way back is closed and the user has to sign in again, MFA included.
        $actorTokenAlive = $actorTokenId !== '' && \DB::table('oauth_access_tokens')
            ->where('id', $actorTokenId)
            ->where('user_id', (int) $actorId)
            ->where('revoked', false)
            ->where('expires_at', '>', now())
            ->exists();

        if (! $actorTokenAlive) {
            throw new UnauthorizedException('Your original session has ended. Please sign in again.');
        }

        $actor = Users::withoutGlobalScopes()->where('id', (int) $actorId)->first();

        if (! $actor || $actor->isAiAgent() || ! self::canSwitch($actor, $agent)) {
            throw new UnauthorizedException('You can not switch back to this user.');
        }

        $session = OAuthService::createSession($clientId, $redirectUri);

        if (! $session) {
            throw new UnauthorizedException('Invalid client or redirect.');
        }

        OAuthService::setSwitchBackValidated($session, $actor, $agent);

        $code = OAuthService::getAuthCode($session, []);

        if (! $code) {
            throw new UnauthorizedException('Could not issue a sign-in code.');
        }

        // The agent session ends here
        \DB::table('oauth_access_tokens')->where('id', $tokenId)->delete();

        CommandLogsService::record([
            'module' => 'iam',
            'action' => 'switch-back-from-ai-agent',
            'operation' => 'system',
            'resource' => 'iam_users',
            'object_type' => 'NextDeveloper\IAM\Users',
            'object_id' => $agent->uuid,
            'context' => [
                'owner_iam_user_id' => $agent->owner_iam_user_id,
                'switched_back_to' => $actor->uuid,
                'agent' => $agent->uuid,
            ],
        ]);

        return $code;
    }

    /**
     * Who the current session is, for the panel banner (#1306): whether the caller is an AI agent, its owner
     * and who switched in (read from the token).
     *
     * @return array{is_ai_agent: bool, agent?: array, owner_id?: ?string, switched_by_id?: ?string}
     */
    public static function status(Users $me, ?string $tokenId): array
    {
        if (! $me->isAiAgent()) {
            return ['is_ai_agent' => false, 'is_ai_assistant' => false];
        }

        $name = $tokenId ? \DB::table('oauth_access_tokens')->where('id', $tokenId)->where('user_id', $me->id)->value('name') : null;
        $switchedById = is_string($name) && str_starts_with($name, AccessTokenService::SWITCH_TOKEN_PREFIX)
            ? (int) explode(':', substr($name, strlen(AccessTokenService::SWITCH_TOKEN_PREFIX)), 2)[0]
            : null;

        return [
            'is_ai_agent' => true,
            'is_ai_assistant' => true, // old key, kept for one release while the panel moves to is_ai_agent
            'agent' => ['id' => $me->uuid, 'name' => $me->name, 'purpose' => self::purposeOf($me)],
            'owner_id' => Users::withoutGlobalScopes()->where('id', $me->owner_iam_user_id)->value('uuid'),
            'switched_by_id' => $switchedById ? Users::withoutGlobalScopes()->where('id', $switchedById)->value('uuid') : null,
        ];
    }

    /**
     * The owner may always switch; an owner of a shared account may too, except a co-owner into the primary
     * owner's agents.
     */
    public static function canSwitch(Users $actor, Users $agent): bool
    {
        if (! $agent->isAiAgent() || $actor->isAiAgent() || $actor->id === $agent->id) {
            return false;
        }

        if ($agent->owner_iam_user_id === $actor->id) {
            return true;
        }

        $sharedAccountIds = AccountUsers::withoutGlobalScopes()
            ->where('iam_user_id', $agent->owner_iam_user_id)
            ->whereIn('iam_account_id', AccountUsers::withoutGlobalScopes()->where('iam_user_id', $actor->id)->select('iam_account_id'))
            ->pluck('iam_account_id');

        foreach (Accounts::withoutGlobalScopes()->whereIn('id', $sharedAccountIds)->get() as $account) {
            if (self::mayUseAgentsOf($actor, $agent->owner_iam_user_id, $account)) {
                return true;
            }
        }

        return false;
    }

    private static function mayUseAgentsOf(Users $actor, int $ownerId, Accounts $account): bool
    {
        if ($ownerId === $actor->id) {
            return true;
        }

        if (! UserHelper::isAccountOwner($actor, $account)) {
            return false;
        }

        // A co-owner must not use the primary owner's agents (same takeover guard as for credentials)
        return $ownerId !== $account->iam_user_id || UserHelper::isPrimaryOwner($actor, $account);
    }

    /** @var array<string, string> */
    private static array $columns = [];

    /**
     * Name of the agent flag column on iam_users. The columns were renamed from is_ai_assistant /
     * ai_assistant_purpose (v1.22.239) to is_ai_agent / ai_agent_purpose; until the rename DDL is applied the old
     * names are used, so the code works on either side of it.
     */
    public static function flagColumn(): string
    {
        return self::$columns['flag'] ??= (Schema::hasColumn('iam_users', 'is_ai_agent') ? 'is_ai_agent' : 'is_ai_assistant');
    }

    public static function purposeColumn(): string
    {
        return self::$columns['purpose'] ??= (Schema::hasColumn('iam_users', 'ai_agent_purpose') ? 'ai_agent_purpose' : 'ai_assistant_purpose');
    }

    public static function purposeOf(Users $user): ?string
    {
        return $user->getAttribute('ai_agent_purpose') ?? $user->getAttribute('ai_assistant_purpose');
    }

    private static function assertColumnsExist(): void
    {
        if (! Schema::hasColumn('iam_users', self::flagColumn())) {
            throw new UnauthorizedException('AI agents are not available yet (database not updated).');
        }
    }
}
