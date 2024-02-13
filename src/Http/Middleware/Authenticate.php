<?php

namespace NextDeveloper\IAM\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use NextDeveloper\IAM\Helpers\UserHelper;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        //  Using this because when we dont return OPTIONS http 200 then browsers are not sending the actual request
        if($request->getMethod() == "OPTIONS")
            return $next($request);

        if (!UserHelper::me()) {
            return response()->json([
                'errors' => [
                    'status'    => 401,
                    'message'   => 'Unauthenticated',
                    'details'   => 'We cannot authenticate you. Please login again or provide a valid token.'
                ],
            ], 401);
        }

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
