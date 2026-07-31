-- PostgreSQL
-- [ui:phone_number]

CREATE TABLE iam_accounts (
    id                   bigint NOT NULL DEFAULT nextval('iam_accounts_id_seq'::regclass),
    uuid                 uuid DEFAULT gen_random_uuid(),
    name                 text NOT NULL,
    common_domain_id     bigint, -- [label:"This is the main domain of your account. Once you select the domain, you cannot change in the future."]
    common_country_id    bigint,
    phone_number         text,
    description          text, -- [ui:markdown]
    iam_user_id          bigint,
    iam_account_type_id  bigint NOT NULL,
    is_active            boolean DEFAULT true,
    tags                 text[] NOT NULL DEFAULT '{}'::text[],
    created_at           timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at           timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at           timestamp with time zone,
    profile_image_url    text,
    CONSTRAINT iam_accounts_pkey PRIMARY KEY (id)
);
