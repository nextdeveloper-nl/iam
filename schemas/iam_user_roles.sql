-- PostgreSQL
-- VIEW (read-only; re-run this file with CREATE OR REPLACE VIEW whenever the SELECT needs to change)

CREATE OR REPLACE VIEW iam_user_roles AS
SELECT iam_role_user.id,
    iam_role_user.uuid,
    iam_roles.name,
    iam_roles.class,
    iam_roles.level,
    iam_roles.description,
    iam_roles.created_at,
    iam_roles.updated_at,
    iam_roles.deleted_at,
    iam_role_user.iam_role_id,
    iam_role_user.iam_user_id,
    iam_role_user.iam_account_id,
    iam_role_user.is_active,
    iam_role_user.role_data
   FROM iam_roles
     JOIN iam_role_user ON iam_roles.id = iam_role_user.iam_role_id
  ORDER BY iam_roles.level DESC;
