-- PostgreSQL

CREATE TABLE iam_ssh_public_keys (
    id              bigint NOT NULL DEFAULT nextval('iam_ssh_public_keys_id_seq'::regclass),
    uuid            uuid NOT NULL DEFAULT gen_random_uuid(),
    name            text NOT NULL,
    public_key      text NOT NULL,
    fingerprint     text,
    key_type        text,
    scope           text NOT NULL DEFAULT 'personal'::text,
    is_active       boolean NOT NULL DEFAULT true,
    tags            text[],
    expires_at      timestamp with time zone,
    last_used_at    timestamp with time zone,
    iam_account_id  bigint NOT NULL,
    iam_user_id     bigint NOT NULL,
    created_at      timestamp with time zone NOT NULL DEFAULT now(),
    updated_at      timestamp with time zone NOT NULL DEFAULT now(),
    deleted_at      timestamp with time zone,
    CONSTRAINT iam_ssh_public_keys_pkey PRIMARY KEY (id)
);
