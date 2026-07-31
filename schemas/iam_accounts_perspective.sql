-- PostgreSQL
-- VIEW (read-only; re-run this file with CREATE OR REPLACE VIEW whenever the SELECT needs to change)

CREATE OR REPLACE VIEW iam_accounts_perspective AS
SELECT id,
    uuid,
    name,
    description,
    phone_number,
    ( SELECT n_iu.fullname
           FROM iam_users n_iu
          WHERE n_iu.id = ia.iam_user_id) AS account_owner,
    iam_user_id,
    ( SELECT n_iat.name
           FROM iam_account_types n_iat
          WHERE n_iat.id = ia.iam_account_type_id) AS account_type,
    is_active,
    tags,
    ( SELECT count(n_iu.id) AS count
           FROM iam_users n_iu
             JOIN ( SELECT DISTINCT iam_account_user.id,
                    iam_account_user.iam_user_id,
                    iam_account_user.iam_account_id
                   FROM iam_account_user) n_iau ON n_iu.id = n_iau.iam_user_id
          WHERE ia.id = n_iau.iam_account_id) AS total_user_count,
    ( SELECT count(n_iu.id) AS count
           FROM iam_users n_iu
             JOIN ( SELECT DISTINCT iam_account_user.id,
                    iam_account_user.iam_user_id,
                    iam_account_user.iam_account_id
                   FROM iam_account_user) n_iau ON n_iu.id = n_iau.iam_user_id
          WHERE ia.id = n_iau.iam_account_id AND n_iu.is_registered = true) AS registered_user_count,
    ( SELECT cd.name
           FROM common_domains cd
          WHERE ia.common_domain_id = cd.id) AS domain_name,
    common_domain_id,
    ( SELECT cc.name
           FROM common_countries cc
          WHERE ia.common_country_id = cc.id) AS country_name,
    profile_image_url,
    common_country_id,
    created_at,
    updated_at,
    deleted_at
   FROM iam_accounts ia
  WHERE deleted_at IS NULL;
