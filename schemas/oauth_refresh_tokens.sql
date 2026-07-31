-- PostgreSQL

CREATE TABLE oauth_refresh_tokens (
    id               uuid NOT NULL DEFAULT gen_random_uuid(),
    access_token_id  uuid NOT NULL,
    revoked          boolean NOT NULL DEFAULT false,
    expires_at       timestamp with time zone,
    CONSTRAINT oauth_refresh_tokens_pkey PRIMARY KEY (id)
);
