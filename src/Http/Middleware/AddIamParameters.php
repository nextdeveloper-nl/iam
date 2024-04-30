<?php

namespace NextDeveloper\IAM\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;
use NextDeveloper\IAM\Helpers\UserHelper;

class AddIamParameters extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        Log::debug('[AddIamParameters] Trying to find user.');

        if(!$request->has('iam_user_id')) {
            $user = UserHelper::me();

            if($user) {
                $request->query->add([
                    'iam_user_id' => $user->uuid
                ]);
            }
        }

        if(!$request->has('iam_account_id')) {
            $account = UserHelper::currentAccount();

            if($account) {
                $request->query->add([
                    'iam_account_id' => $account->uuid
                ]);
            }
        }

        return $next($request);
    }
}
