<?php

namespace NextDeveloper\IAM\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use NextDeveloper\I18n\Helpers\i18n;

/**
 * Response envelopes of the authentication endpoints.
 *
 * These used to come from the host application (App\Helpers\Http\ResponseHelper), which
 * made every OAuth endpoint a class-not-found error in any application that does not ship
 * that class. The shapes are unchanged, because the sign-in clients already read them:
 *
 *  - data:   { data, error: false, meta: null }
 *  - error:  HTTP 424 { message, helper, error: true, meta: null }
 *  - status: { data: { message, helper }, error: false, meta: null }
 */
class ResponseHelper
{
    public static function data($data): array
    {
        return [
            'data'  =>  $data,
            'error' =>  false,
            'meta'  =>  null
        ];
    }

    public static function error($message, $helper = ''): JsonResponse
    {
        $languageId = self::languageId();

        return Response::json([
            'message'   =>  I18n::t($message, $languageId),
            'helper'    =>  I18n::t($helper, $languageId),
            'error'     =>  true,
            'meta'      =>  null
        ], 424);
    }

    public static function status($message, $helper = ''): array
    {
        $languageId = self::languageId();

        return [
            'data'  =>  [
                'message'   =>  I18n::t($message, $languageId),
                'helper'    =>  I18n::t($helper, $languageId),
            ],
            'error' =>  false,
            'meta'  =>  null
        ];
    }

    /**
     * Authentication endpoints are usually called without a token, so there may be no user
     * to take the language from.
     */
    private static function languageId(): ?int
    {
        $me = UserHelper::me();

        return $me ? $me->common_language_id : null;
    }
}
