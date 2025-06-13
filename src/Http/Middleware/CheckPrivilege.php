<?php

namespace NextDeveloper\IAM\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Bridge\User;

class CheckPrivilege extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        Log::debug('[CheckPrivilege] Checking if the user has privilege to make the request.');



        return $next($request);
    }
}
