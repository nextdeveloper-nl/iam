# AI agent users (leo4#1306)

A human user can have several AI (robot) agent users, one per purpose. They are real `iam_users` rows that can
never sign in by themselves; the owner (or an owner of a shared account) switches to them from the panel.

## Required database change (apply by hand; no migrations)

```sql
-- Already applied for the first release (leo4#1306), as is_ai_assistant / ai_assistant_purpose. Rename for the rename:
ALTER TABLE iam_users RENAME COLUMN is_ai_assistant TO is_ai_agent;
ALTER TABLE iam_users RENAME COLUMN ai_assistant_purpose TO ai_agent_purpose;
ALTER INDEX iam_users_ai_assistant_owner_purpose_uq RENAME TO iam_users_ai_agent_owner_purpose_uq;
```

For a fresh database, create the columns directly under the new names:

```sql
ALTER TABLE iam_users
    ADD COLUMN is_ai_agent boolean NOT NULL DEFAULT false,
    ADD COLUMN owner_iam_user_id bigint REFERENCES iam_users(id),
    ADD COLUMN ai_agent_purpose text;

CREATE UNIQUE INDEX iam_users_ai_agent_owner_purpose_uq
    ON iam_users (owner_iam_user_id, ai_agent_purpose)
    WHERE is_ai_agent AND deleted_at IS NULL;

CREATE INDEX iam_users_owner_iam_user_id_idx ON iam_users (owner_iam_user_id) WHERE owner_iam_user_id IS NOT NULL;
```

The code uses the new names when they exist and the old ones otherwise, so the rename can be applied before or after the deploy.

Until it is applied the service throws "AI agents are not available yet" and nothing else changes.

## Rules

- No login: `OAuthService::getAuthCode()` and `AccessTokenService::getAccessTokenFromAuthCode()` refuse agent
  sessions unless created by `AiAgentsService::switchTo()`. `PasswordService::setPassword()` refuses agents.
  Email is a synthetic `agent-<uuid>@agents.invalid`.
- Switch: the owner, or an owner of an account the owner is a member of; a co-owner can not use the primary
  owner's agents. Audited in the command log (`switch-to-ai-agent`) with the owner and the actor.
- Roles: agents only get the `member` role, in every account the owner belongs to.
- Agents count toward seats like any member.
