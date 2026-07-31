-- PostgreSQL

CREATE TABLE iam_login_mechanisms (
    id               bigint NOT NULL DEFAULT nextval('iam_login_mechanisms_id_seq'::regclass),
    uuid             uuid DEFAULT gen_random_uuid(),
    iam_user_id      bigint,
    login_client     character varying(1000),
    login_data       json,
    login_mechanism  text,
    is_latest        boolean DEFAULT true,
    is_default       boolean DEFAULT true,
    is_active        boolean DEFAULT true,
    created_at       timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at       timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at       timestamp with time zone,
    CONSTRAINT iam_login_mechanisms_pkey PRIMARY KEY (id)
);
