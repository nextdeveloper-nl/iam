<?php

namespace NextDeveloper\IAM\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use NextDeveloper\IAM\Helpers\UserHelper;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        //  Using this because when we dont return OPTIONS http 200 then browsers are not sending the actual request
        if($request->getMethod() == "OPTIONS")
            return $next($request);

        if(Str::startsWith($request->getRequestUri(), '/iam/authentication')) {
            if(config('leo.debug.authorization_roles'))
                Log::debug('[Authenticate] Request URI starts with /iam/authentication that is why I am not authenticating.');

            return $next($request);
        }

        if(Str::startsWith($request->getRequestUri(), '/public')) {
            if(config('leo.debug.authorization_roles'))
                Log::debug('[Authenticate] Request URI starts with /public that is why I am not authenticating.');

            return $next($request);
        }

        //  If the request is for an anonymous uri then we can just return the request
        //  Because this is out of our scope. We are only interested in the requests that are for a module
        if(config('app.anonymous_uris')) {
            foreach (config('app.anonymous_uris') as $uri) {
                if(Str::contains($uri, '*')) {
                    if(Str::startsWith($request->getRequestUri(), Str::before($uri, '*'))) {
                        //  This means that the request is for an anonymous uri
                        return $next($request);
                    }
                }

                if($request->getRequestUri() == $uri) {
                    return $next($request);
                }
            }
        }

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
