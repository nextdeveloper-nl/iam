-- PostgreSQL

CREATE TABLE iam_users (
    id                        bigint NOT NULL DEFAULT nextval('iam_users_id_seq'::regclass),
    uuid                      uuid DEFAULT gen_random_uuid(),
    name                      text,
    surname                   text,
    email                     text NOT NULL,
    fullname                  text GENERATED ALWAYS AS (
CASE
    WHEN (name IS NULL) THEN surname
    WHEN (surname IS NULL) THEN name
    ELSE ((name || ' '::text) || surname)
END) STORED, -- [ro]
    username                  text,
    about                     text, -- [ui:markdown]
    pronoun                   text,
    birthday                  date,
    nin                       text, -- [label:"This is the national identity number of the user. This may not be applicable to everybody."]
    common_language_id        bigint,
    common_country_id         bigint,
    phone_number              text,
    tags                      text[] NOT NULL DEFAULT '{}'::text[],
    created_at                timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at                timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at                timestamp with time zone,
    is_registered             boolean DEFAULT false, -- [ro]
    profile_picture_identity  bigint, -- [ui:image]
    is_active                 boolean DEFAULT true,
    is_nin_verified           boolean DEFAULT false,
    is_email_verified         boolean DEFAULT true,
    is_phone_number_verified  boolean DEFAULT false,
    is_profile_verified       boolean NOT NULL DEFAULT false,
    CONSTRAINT iam_users_pkey PRIMARY KEY (id)
);
