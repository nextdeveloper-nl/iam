-- PostgreSQL
-- VIEW (read-only; re-run this file with CREATE OR REPLACE VIEW whenever the SELECT needs to change)

CREATE OR REPLACE VIEW iam_account_users_perspective AS
SELECT DISTINCT iam_users.id,
    iam_users.uuid,
    iam_users.name,
    iam_users.surname,
    iam_users.email,
    iam_users.fullname,
    iam_users.username,
    iam_users.about,
    iam_users.pronoun,
    iam_users.birthday,
    iam_users.nin,
    iam_users.common_language_id,
    iam_users.common_country_id,
    iam_users.created_at,
    iam_users.updated_at,
    iam_users.deleted_at,
    iam_users.phone_number,
    iam_account_user.iam_account_id,
    iam_account_user.is_active
   FROM iam_users
     JOIN iam_account_user ON iam_users.id = iam_account_user.iam_user_id
  WHERE iam_account_user.iam_account_id = 5;
