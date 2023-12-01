<?php

namespace NextDeveloper\IAM\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use NextDeveloper\IAM\Authorization\Roles\AnonymousRole;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\RolesService;

class AuthorizationScope implements Scope
{
    /**
     * This function applies the role of the related user.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model) : void
    {
        Log::debug('[AuthorizationScope] Adding authorization scope for model: ' . $model->getTable() );

        //  This is here to fix unwanted multiple applications of this scope
        if($this->isRoleApplied($builder, $model))
            return;

        //  Here we are bypassing iam_user table. Because we cannot get the user login information
        //  if we cannot get the user and this creates a constant loop. That is why we need to secure
        //  user information from the service.
        if(
            $model->getTable() == 'iam_accounts' || //  This creates a recursive loop when we need currentRole
            $model->getTable() == 'iam_users' ||
            $model->getTable() == 'iam_roles' ||
            $model->getTable() == 'iam_role_user' ||
            $model->getTable() == 'iam_account_user' ||
            $model->getTable() == 'iam_view_user_account' ||
            $model->getTable() == 'iam_login_mechanisms'
        ) {
            Log::debug('[AuthorizationScope] Bypassing model : ' . $model->getTable());
            return;
        }

        //  This scope works for automated filtering of model requests. By using this global scope we have the
        //  capability to inject sql to the model. This way we don't need to deal with the security, most of the time.
        if($this->isBypass(request(), config('iam.auth_bypass_uris'))){
            Log::debug('[AuthorizationScope] Bypassing because URI is: ' . request()->getRequestUri());
            return;
        }

        $scope = $this->getAnonymous();

        if(UserHelper::currentRole()) {
            $scope = $this->getDefault();
            Log::debug('[AuthorizationScope] My user has role. Applying default: ' . get_class($scope));
        }

        Log::debug('[AuthorizationScope] Checking if the role is applied to this model.');
        //  If we don't check if the role is applied then we may have a recursive loop here !!!
        if($this->isRoleApplied($builder, $model)) {
            return;
        }

        $model->setHidden([
            'is_authorized' => true
        ]);

        Log::debug('[AuthorizationScope] Applying role: ' . get_class($scope));
        Log::debug('[AuthorizationScope] Applying to model: ' . $model->getTable());
        $scope->apply($builder, $model);
    }

    /**
     * This will be implemented
     *
     * @param $builder
     * @param $model
     * @return bool
     */
    private function isRoleApplied(Builder $builder, Model $model) : bool
    {
        if($model->getHidden()) {
            //  @todo: Should be revisited
            return true;
        }

        return false;
    }

    /**
     *
     *
     * @param Request $request
     * @param $uris
     * @return bool
     */
    private function isBypass(Request $request, $uris) {
        foreach ($uris as $uri) {
            if($uri == $request->getRequestUri())
                return true;
        }

        return false;
    }

    private function getAnonymous() {
        return new AnonymousRole();
    }

    private function getDefault() {
        $account = UserHelper::currentAccount();
        //  We are getting the highest level role of user.
        $role = RolesService::getUserRole(UserHelper::me(), $account);

        return app($role->class);
    }
}
