-- PostgreSQL
-- VIEW (read-only; re-run this file with CREATE OR REPLACE VIEW whenever the SELECT needs to change)

CREATE OR REPLACE VIEW iam_users_perspective AS
SELECT ia.id,
    ia.uuid,
    ia.name,
    ia.surname,
    ia.email,
    ia.fullname,
    ia.username,
    ia.about,
    ia.pronoun,
    ia.birthday,
    ia.nin,
    ia.common_country_id,
    ( SELECT n_cc.name
           FROM common_countries n_cc
          WHERE n_cc.id = ia.common_country_id) AS country,
    ia.common_language_id,
    ( SELECT n_cl.name
           FROM common_languages n_cl
          WHERE n_cl.id = ia.common_language_id) AS language,
    ia.phone_number,
    ia.tags,
    ARRAY( SELECT iur.name
           FROM iam_user_roles iur
          WHERE iur.iam_user_id = ia.id AND iua.iam_account_id = iur.iam_account_id AND iur.is_active = true) AS roles,
    ( SELECT n_cm.cdn_url
           FROM common_media n_cm
          WHERE n_cm.object_id = ia.profile_picture_identity AND n_cm.object_type = 'NextDeveloper\IAM\Database\Models\Users'::text) AS profile_picture,
    ( SELECT (EXISTS ( SELECT 1
                   FROM iam_login_mechanisms ilm
                  WHERE ilm.iam_user_id = ia.id AND ilm.login_mechanism = 'GoogleLogin'::text AND ilm.is_active = true)) AS "exists") AS has_valid_google_login,
    ia.is_registered,
    ia.is_active,
    ia.is_nin_verified,
    ia.is_email_verified,
    ia.is_phone_number_verified,
    ia.is_profile_verified,
    iua.iam_account_id,
    ia.created_at,
    ia.updated_at,
    ia.deleted_at
   FROM iam_users ia
     LEFT JOIN iam_account_user iua ON ia.id = iua.iam_user_id
  WHERE iua.is_active = true AND ia.deleted_at IS NULL;
