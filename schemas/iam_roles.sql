-- PostgreSQL

CREATE TABLE iam_roles (
    id           bigint NOT NULL DEFAULT nextval('iam_roles_id_seq'::regclass),
    uuid         uuid DEFAULT gen_random_uuid(),
    name         text NOT NULL,
    class        text,
    level        smallint NOT NULL,
    description  text,
    created_at   timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at   timestamp with time zone,
    CONSTRAINT iam_roles_pkey PRIMARY KEY (id)
);
