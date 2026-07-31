-- PostgreSQL

CREATE TABLE iam_permissions (
    id          bigint NOT NULL DEFAULT nextval('iam_permissions_id_seq'::regclass),
    uuid        uuid DEFAULT gen_random_uuid(),
    namespace   text,
    service     text,
    method      text NOT NULL,
    name        text,
    is_active   boolean DEFAULT true,
    created_by  bigint NOT NULL,
    updated_by  bigint,
    created_at  timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT iam_permissions_pkey PRIMARY KEY (id)
);
