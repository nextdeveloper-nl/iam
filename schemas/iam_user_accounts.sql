-- PostgreSQL
-- VIEW (read-only; re-run this file with CREATE OR REPLACE VIEW whenever the SELECT needs to change)

CREATE OR REPLACE VIEW iam_user_accounts AS
SELECT iam_accounts.id,
    iam_accounts.uuid,
    iam_accounts.name,
    iam_accounts.common_domain_id,
    iam_accounts.common_country_id,
    iam_accounts.created_at,
    iam_accounts.updated_at,
    iam_accounts.deleted_at,
    iam_account_user.iam_user_id,
    iam_account_user.iam_account_id,
    iam_account_user.is_active,
    iam_account_user.session_data
   FROM iam_users
     JOIN iam_account_user ON iam_users.id = iam_account_user.iam_user_id
     JOIN iam_accounts ON iam_account_user.iam_account_id = iam_accounts.id
  WHERE iam_accounts.deleted_at IS NULL;
