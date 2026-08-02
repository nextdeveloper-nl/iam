-- PostgreSQL
-- Custom enum type used by iam_backend_directories (reconstructed from
-- database.leo.v4/PostgreSQL/InitialData/Create Custom Types.sql).

DO $$ BEGIN
    CREATE TYPE iam_backend_types AS ENUM ('plusclouds-iam', 'ldap', 'active-directory', 'keycloak');
EXCEPTION
    WHEN duplicate_object THEN NULL;
END $$;
