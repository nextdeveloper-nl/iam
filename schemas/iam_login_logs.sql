-- PostgreSQL

CREATE TABLE iam_login_logs (
    id           bigint NOT NULL DEFAULT nextval('iam_login_logs_id_seq'::regclass),
    uuid         uuid DEFAULT gen_random_uuid(),
    iam_user_id  bigint,
    log          json,
    created_at   timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT iam_login_logs_pkey PRIMARY KEY (id)
);
