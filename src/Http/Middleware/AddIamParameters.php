<?php

namespace NextDeveloper\IAM\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use NextDeveloper\IAM\Helpers\UserHelper;

class AddIamParameters extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $requestUri = $request->getRequestUri();

        if(Str::startsWith($requestUri, '/public')) {
            if(config('leo.debug.authorization_roles'))
                Log::debug('[AddIamParameters] Request URI starts with /public that is why I am not adding IAM params.');

            return $next($request);
        }

        if(config('leo.debug.authorization_roles'))
            Log::debug('[AddIamParameters] Trying to find user.');

        if(!$request->has('iam_user_id')) {
            $user = UserHelper::me();

            if($user) {
                $request->query->add([
                    //'iam_user_id' => $user->uuid,
                    //  We are removing this below because it is creating a unwanted behaviour of
                    //  filtering all objects if the owner is themselves
                    // 'iamUserId' => $user->uuid
                ]);
            }
        }

        if(!$request->has('iam_account_id')) {
            $account = UserHelper::currentAccount();

            if($account) {
                $request->query->add([
                    'iam_account_id' => $account->uuid,
                    //  We are removing this below because it is creating a unwanted behaviour of
                    //  filtering all objects if the owner is themselves
                    // 'iamAccountId' => $account->uuid
                ]);
            } else {
                $request->query->add([
                    //  Actually sending the iam_account_id to null.
                    'iam_account_id' => 0
                ]);
            }
        }

        Log::info('AddIamParams: ' . $request->getRequestUri());
        return $next($request);
    }
}
