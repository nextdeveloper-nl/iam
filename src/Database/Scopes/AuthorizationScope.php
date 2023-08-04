<?php

namespace NextDeveloper\IAM\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use NextDeveloper\IAM\Authorization\Roles\AnonymousRole;
use NextDeveloper\IAM\Database\Models\IamUser;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\IamRoleService;

class AuthorizationScope implements Scope
{
    /**
     * @var IamUser
     */
    private IamUser $_user;

    /**
     * This function applies the role of the related user.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model) : void
    {
        //  Here we are bypassing iam_user table. Because we cannot get the user login information
        //  if we cannot get the user and this creates a constant loop. That is why we need to secure
        //  user information from the service.
        if(
            $model->getTable() == 'iam_users' ||
            $model->getTable() == 'iam_accounts'
        )
            return;

        Log::debug('[AuthorizationScope@apply] Model: ' . $model->getTable() );

        //  This scope works for automated filtering of model requests. By using this global scope we have the
        //  capability to inject sql to the model. This way we dont need to deal with the security, most of the time.
        if($this->isBypass(request(), config('iam.auth_bypass_uris'))){
            Log::debug('[AuthorizationScope@apply] Bypassing because URI is: ' . request()->getRequestUri());
            return;
        }

        $this->_user = UserHelper::me();

        Log::debug('[AuthorizationScope@apply] Is user object available: ' . is_null($this->_user));

        if(!$this->_user) {
            $this->applyAnonymous($builder, $model);
        }

        $this->applyDefault($builder, $model);
    }

    private function isBypass(Request $request, $uris) {
        foreach ($uris as $uri) {
            if($uri == $request->getRequestUri())
                return true;
        }

        return false;
    }

    private function applyAnonymous(Builder $builder, Model $model) {
        Log::debug('[AuthorizationScope@apply] Applying anonymous for this request:
        ' . request()->getRequestUri());

        $scope = new AnonymousRole();

        $scope->apply($builder, $model);
    }

    private function applyDefault(Builder $builder, Model $model) {
        $account = UserHelper::currentAccount();
        //  We are getting the highest level role of user.
        $role = IamRoleService::getUserRole($this->_user, $account);

        Log::debug('[AuthorizationScope@apply] Applying role: ' . $role->class);

        $scope = app($role->class);

        $scope->apply($builder, $model);
    }
}