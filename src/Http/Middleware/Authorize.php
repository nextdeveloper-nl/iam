<?php

namespace NextDeveloper\IAM\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use NextDeveloper\IAM\Helpers\UserHelper;

class Authorize extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        //  Using this because when we dont return OPTIONS http 200 then browsers are not sending the actual request
        if($request->getMethod() == "OPTIONS")
            return $next($request);

        if($request->getRequestUri() == '/generator/all')
            return $next($request);

        $requestUri = $request->getRequestUri();
        $requestMethod = $request->getMethod();

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

        if(Str::startsWith($requestUri, '/iam/authentication')) {
            if(config('leo.debug.authorization_roles'))
                Log::debug('[Authorize] Since the user is trying to login we are not running authorization rules');

            return $next($request);
        }

        if(Str::startsWith($requestUri, '/public')) {
            if(config('leo.debug.authorization_roles'))
                Log::debug('[Authorize] Request URI starts with /public that is why I am not adding IAM params.');

            return $next($request);
        }

        if(Str::startsWith($requestUri, '/'))
            $requestUri = substr($requestUri, 1); // Remove leading slash for consistency

        $explode = explode('/', $requestUri);

        $roles = UserHelper::getRoles();

        //  If the request is not for a module then we can just return the request
        //  Because this is out of our scope. We are only interested in the requests that are for a module
        if(count($explode) > 2)
            return $next($request);

        //  Perspective is a special case, we need to remove it from the object name
        if(Str::contains($explode[1], '_perspective')) {
            $explode[1] = str_replace('_perspective', '', $explode[1]);
        }

        $module = $explode[0];
        $object = $explode[1];

        //  Commons is a special case because the module is called common in the permissions
        if($module == 'commons') $module = 'common';
        if($module == 'blogs') $module = 'blog';

        if(strpos($object, '?') !== false) {
            $object = substr($object, 0, strpos($object, '?'));
        }
        $object = str_replace('-', '_', $object);

        /**
         * Creating the operation string based on the request method
         */
        $operationString = '';

        switch ($requestMethod) {
            case 'GET':
                $operationString = $module . '_' . $object . ':read';
                break;
            case 'POST':
                $operationString = $module . '_' . $object . ':create';
                break;
            case 'PATCH':
            case 'PUT':
                $operationString = $module . '_' . $object . ':update';
                break;
            case 'DELETE':
                $operationString = $module . '_' . $object . ':delete';
                break;
        }

        $skipCheck = false;

        //  Here we are checking the authorization cache, if the user is authorized for this operation
        $authCache = Cache::get('auth' . UserHelper::me()->id . '|' . UserHelper::currentAccount()->id . '|' . $operationString);

        if($authCache) {
            //  If the operation is allowed then we can return the request
            if($authCache['allowed'] == true) {
                if(config('leo.debug.authorization_roles'))
                    Log::debug('[Authorize] Operation starts with ' . $operationString . ' is in cache, so we are allowing it.');

                return $next($request);
            }

            //  If the operation is not allowed then we can return a 403 error
            if(config('leo.debug.authorization_roles'))
                Log::debug('[Authorize] Operation starts with ' . $operationString . ' is in cache, so we are denying it.');

            $skipCheck = true;
        }

        $testedAgainstRoles = [];

        //  We already know the result because we checked from cache
        if(!$skipCheck) {
            foreach ($roles as $role) {
                $testedAgainstRoles[] = $role->name;

                if(!class_exists($role->class))
                    continue;

                $roleObject = app($role->class);

                $allowedOperations = $roleObject->allowedOperations();

                if($allowedOperations[0] == "*:*") {
                    return $next($request);
                }

                Log::debug('[Authorize] Checking if operation: ' . $operationString . ' is in allowed operations for role: ' . $role->name);

                //  Now we need to check if the current request is allowed for the current user
                foreach ($allowedOperations as $operation) {
                    $withoutPerspective = str_replace('_perspective', '', $operationString);

                    if(in_array($operationString, $allowedOperations)) {
                        Log::info('Authorize: ' . $request->getRequestUri());

                        Cache::set('auth' . UserHelper::me()->id . '|' . UserHelper::currentAccount()->id . '|' . $operationString, [
                            'role' => $role->name,
                            'operation' => $operationString,
                            'allowed' => true
                        ], 600);

                        return $next($request);
                    } elseif(in_array($withoutPerspective, $allowedOperations)) {
                        //  We are caching the authorization for 10 minutes, because we don't want to check the same
                        Cache::set('auth' . UserHelper::me()->id . '|' . UserHelper::currentAccount()->id . '|' . $operationString, [
                            'role' => $role->name,
                            'operation' => $operationString,
                            'allowed' => true
                        ], 600);

                        Log::info('Authorize: ' . $request->getRequestUri());
                        return $next($request);
                    } else {
                        Log::debug('[Authorize|Short] Not allowed ' . $operationString . ' / ' . $role->name . ' ]');
                        Log::debug('[Authorize] The user with email: ' . UserHelper::me()->email . ' is asking' .
                            ' for operation: ' . $operationString . ' but he is not allowed to do that' .
                            ' with this role: ' . $role->name);
                    }
                }
            }
        }

        Cache::set('auth' . UserHelper::me()->id . '|' . UserHelper::currentAccount()->id . '|' . $operationString, [
            'request-uri' => $request->getRequestUri(),
            'tested-against' => implode('|', $testedAgainstRoles),
            'operation' => $operationString,
            'allowed' => false
        ], 600);

        return response()->json([
            'errors' => [
                'status'    => 403,
                'message'   => 'Unauthorized',
                'details'   => 'We cannot authorize you to complete this operation, unfortunately.' .
                    ' You may need to ask your admin to change your role.'
            ],
        ], 403);
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
