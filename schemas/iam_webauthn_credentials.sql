-- PostgreSQL
-- Passkeys (WebAuthn). One row per credential; a user may have several. Applied by hand like the other schemas here.

CREATE SEQUENCE iam_webauthn_credentials_id_seq;

CREATE TABLE iam_webauthn_credentials (
    id             bigint NOT NULL DEFAULT nextval('iam_webauthn_credentials_id_seq'::regclass),
    uuid           uuid DEFAULT gen_random_uuid(),
    iam_user_id    bigint NOT NULL,
    credential_id  text NOT NULL,
    public_key     text NOT NULL,
    sign_count     bigint NOT NULL DEFAULT 0,
    transports     json,
    aaguid         uuid,
    name           character varying(255),
    is_backed_up   boolean DEFAULT false,
    last_used_at   timestamp with time zone,
    is_active      boolean DEFAULT true,
    created_at     timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at     timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at     timestamp with time zone,
    CONSTRAINT iam_webauthn_credentials_pkey PRIMARY KEY (id),
    CONSTRAINT iam_webauthn_credentials_user_fk FOREIGN KEY (iam_user_id) REFERENCES iam_users (id)
);

ALTER SEQUENCE iam_webauthn_credentials_id_seq OWNED BY iam_webauthn_credentials.id;
CREATE UNIQUE INDEX iam_webauthn_credentials_credential_id_uq ON iam_webauthn_credentials (credential_id) WHERE deleted_at IS NULL;
CREATE INDEX iam_webauthn_credentials_user_idx ON iam_webauthn_credentials (iam_user_id) WHERE deleted_at IS NULL;
