-- PostgreSQL

CREATE TABLE iam_role_permission (
    id                 bigint NOT NULL DEFAULT nextval('iam_role_permission_id_seq'::regclass),
    uuid               uuid DEFAULT gen_random_uuid(),
    iam_role_id        bigint NOT NULL,
    iam_permission_id  bigint NOT NULL,
    is_active          boolean DEFAULT true,
    created_by         bigint,
    created_at         timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    updated_by         bigint,
    updated_at         timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT iam_role_permission_pkey PRIMARY KEY (id)
);
