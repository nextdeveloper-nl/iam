-- PostgreSQL

CREATE TABLE oauth_access_tokens (
    id                  uuid NOT NULL DEFAULT gen_random_uuid(),
    user_id             bigint,
    client_id           uuid NOT NULL,
    name                text,
    scopes              text,
    revoked             boolean NOT NULL DEFAULT false,
    created_at          timestamp with time zone,
    updated_at          timestamp with time zone,
    expires_at          timestamp with time zone,
    uuid                uuid DEFAULT gen_random_uuid(),
    user_agent          text,
    ip_address          text,
    device_fingerprint  text,
    platform            text,
    language            text,
    timezone_offset     text,
    screen_color_depth  text,
    account_id          bigint,
    CONSTRAINT oauth_access_tokens_pkey PRIMARY KEY (id)
);
