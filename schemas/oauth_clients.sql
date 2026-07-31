-- PostgreSQL

CREATE TABLE oauth_clients (
    id                      uuid NOT NULL DEFAULT gen_random_uuid(),
    user_id                 bigint,
    account_id              bigint,
    name                    text NOT NULL,
    provider                text,
    secret                  text NOT NULL,
    redirect                text NOT NULL,
    personal_access_client  boolean NOT NULL DEFAULT false,
    password_client         boolean NOT NULL DEFAULT false,
    revoked                 boolean NOT NULL DEFAULT false,
    created_at              timestamp with time zone,
    updated_at              timestamp with time zone,
    CONSTRAINT oauth_clients_pkey PRIMARY KEY (id)
);
