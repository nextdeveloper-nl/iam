<?php

namespace NextDeveloper\IAM\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;
use NextDeveloper\IAM\Helpers\UserHelper;

class Authorize extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        //  Using this because when we dont return OPTIONS http 200 then browsers are not sending the actual request
        if($request->getMethod() == "OPTIONS")
            return $next($request);

        $roles = UserHelper::getRoles();

        $requestUri = $request->getRequestUri();
        $requestMethod = $request->getMethod();
        $explode = explode('/', $requestUri);

        //  If the request is not for a module then we can just return the request
        //  Because this is out of our scope. We are only interested in the requests that are for a module
        if(count($explode) > 2)
            return $next($request);

        if (count($explode) <= 2) {
            $tempObject = $explode[1];
            $explode[1] = config('leo.default_module', 'leo');
            $explode[2] = $tempObject;
        }

        $module = $explode[1];
        $object = $explode[2];
        $object = str_replace('-', '_', $object);

        foreach ($roles as $role) {
            $roleObject = app($role->class);

            $allowedOperations = $roleObject->allowedOperations();

            if($allowedOperations[0] == "*:*") {
                return $next($request);
            }

            //  Now we need to check if the current request is allowed for the current user
            foreach ($allowedOperations as $operation) {
                $explode = explode(':', $operation);

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

                if(in_array($operationString, $allowedOperations)) {
                    return $next($request);
                } else {
                    Log::debug('[Authorize] The user with email: ' . UserHelper::me()->email . ' is asking' .
                        ' for operation: ' . $operationString . ' but he is not allowed to do that' .
                        ' with this role: ' . $role->name);
                }
            }
        }

        return response()->json([
            'errors' => [
                'status'    => 403,
                'message'   => 'Unauthorized',
                'details'   => 'We cannot authorize you to complete this operation, unfortunately.' .
                    ' You may need to ask your adminto change your role.'
            ],
        ], 401);
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
