<?php

namespace NextDeveloper\IAM\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Bridge\User;
use NextDeveloper\IAM\Helpers\UserHelper;

class CheckPrivilege extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        Log::debug('[CheckPrivilege] Checking if the user has privilege to make the request.');

        /**
         * Here we will check if the person who makes the request has the privilege to make POST PUT PATCH DELETE requests.
         */

        return $next($request);
    }
}
