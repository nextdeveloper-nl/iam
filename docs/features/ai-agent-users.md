# AI assistant users (leo4#1306)

A human user can have several AI (robot) assistant users, one per purpose. They are real `iam_users` rows that can
never sign in by themselves; the owner (or an owner of a shared account) switches to them from the panel.

## Required database change (apply by hand; no migrations)

```sql
ALTER TABLE iam_users
    ADD COLUMN is_ai_assistant boolean NOT NULL DEFAULT false,
    ADD COLUMN owner_iam_user_id bigint REFERENCES iam_users(id),
    ADD COLUMN ai_assistant_purpose text;

-- one assistant per owner per purpose
CREATE UNIQUE INDEX iam_users_ai_assistant_owner_purpose_uq
    ON iam_users (owner_iam_user_id, ai_assistant_purpose)
    WHERE is_ai_assistant AND deleted_at IS NULL;

CREATE INDEX iam_users_owner_iam_user_id_idx ON iam_users (owner_iam_user_id) WHERE owner_iam_user_id IS NOT NULL;
```

Until it is applied the service throws "AI assistants are not available yet" and nothing else changes.

## Rules

- No login: `OAuthService::getAuthCode()` and `AccessTokenService::getAccessTokenFromAuthCode()` refuse assistant
  sessions unless created by `AiAssistantsService::switchTo()`. `PasswordService::setPassword()` refuses assistants.
  Email is a synthetic `assistant-<uuid>@assistants.invalid`.
- Switch: the owner, or an owner of an account the owner is a member of; a co-owner can not use the primary
  owner's assistants. Audited in the command log (`switch-to-ai-assistant`) with the owner and the actor.
- Roles: assistants only get the `member` role, in every account the owner belongs to.
- Assistants count toward seats like any member.
