-- PostgreSQL

CREATE TABLE oauth_personal_access_clients (
    id          uuid NOT NULL DEFAULT gen_random_uuid(),
    client_id   uuid NOT NULL,
    created_at  timestamp with time zone,
    updated_at  timestamp with time zone,
    CONSTRAINT oauth_personal_access_clients_pkey PRIMARY KEY (id)
);
