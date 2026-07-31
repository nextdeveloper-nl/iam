-- PostgreSQL

CREATE TABLE iam_role_user (
    id              bigint NOT NULL DEFAULT nextval('iam_role_user_id_seq'::regclass),
    uuid            uuid DEFAULT gen_random_uuid(),
    iam_role_id     bigint NOT NULL,
    iam_user_id     bigint NOT NULL,
    iam_account_id  bigint,
    is_active       boolean NOT NULL DEFAULT true,
    role_data       json,
    CONSTRAINT iam_role_user_pkey PRIMARY KEY (id)
);
