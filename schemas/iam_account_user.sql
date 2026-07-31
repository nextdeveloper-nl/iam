-- PostgreSQL

CREATE TABLE iam_account_user (
    id              bigint NOT NULL DEFAULT nextval('iam_account_user_id_seq'::regclass),
    uuid            uuid DEFAULT gen_random_uuid(),
    iam_user_id     bigint NOT NULL,
    iam_account_id  bigint NOT NULL,
    is_active       boolean NOT NULL DEFAULT true,
    session_data    json,
    CONSTRAINT iam_account_user_pkey PRIMARY KEY (id)
);
