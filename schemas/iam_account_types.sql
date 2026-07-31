-- PostgreSQL

CREATE TABLE iam_account_types (
    id                 bigint NOT NULL DEFAULT nextval('iam_account_types_id_seq'::regclass),
    uuid               uuid DEFAULT gen_random_uuid(),
    name               text NOT NULL,
    description        text,
    common_country_id  bigint NOT NULL,
    CONSTRAINT iam_account_types_pkey PRIMARY KEY (id)
);
