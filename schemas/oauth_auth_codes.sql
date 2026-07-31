-- PostgreSQL

CREATE TABLE oauth_auth_codes (
    id           uuid NOT NULL DEFAULT gen_random_uuid(),
    user_id      bigint NOT NULL,
    client_id    uuid NOT NULL,
    scopes       text,
    revoked      boolean NOT NULL DEFAULT false,
    expires_at   timestamp with time zone,
    fingerprint  json,
    CONSTRAINT oauth_auth_codes_pkey PRIMARY KEY (id)
);
