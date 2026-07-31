-- PostgreSQL

CREATE TABLE iam_ssh_public_key_events (
    id                     bigint NOT NULL DEFAULT nextval('iam_ssh_public_key_events_id_seq'::regclass),
    uuid                   uuid NOT NULL DEFAULT gen_random_uuid(),
    iam_ssh_public_key_id  bigint NOT NULL,
    action                 character varying(64) NOT NULL,
    iam_user_id            bigint NOT NULL,
    iam_account_id         bigint NOT NULL,
    ip_addr                character varying(45),
    meta                   json,
    created_at             timestamp without time zone NOT NULL DEFAULT now(),
    updated_at             timestamp with time zone NOT NULL DEFAULT now(),
    deleted_at             timestamp with time zone,
    CONSTRAINT iam_ssh_public_key_events_pkey PRIMARY KEY (id)
);
