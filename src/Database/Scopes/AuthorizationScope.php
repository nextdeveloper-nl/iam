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
        if(config('leo.debug.authorization_scope'))
            Log::info('[AuthorizationScope] Adding authorization scope for model: ' . $model->getTable() );

        //  This is here to fix unwanted multiple applications of this scope
        if($this->isRoleApplied($builder, $model))
            return;

        //  Here we are bypassing iam_user table. Because we cannot get the user login information
        //  if we cannot get the user and this creates a constant loop. That is why we need to secure
        //  user information from the service.
        if(
            $model->getTable() == 'common_currencies' || //  Since this is common table, we dont need to apply any role
            $model->getTable() == 'common_countries' || //  Since this is common table, we dont need to apply any role
            $model->getTable() == 'iam_users'
            //$model->getTable() == 'iam_roles' ||
            //$model->getTable() == 'iam_role_user' ||
            //$model->getTable() == 'iam_account_user' ||
            //$model->getTable() == 'iam_view_user_account' ||
            //$model->getTable() == 'iam_login_mechanisms'
        ) {
            if(config('leo.debug.authorization_scope'))
                Log::info('[AuthorizationScope] Bypassing model : ' . $model->getTable());

            return;
        }

        //  This scope works for automated filtering of model requests. By using this global scope we have the
        //  capability to inject sql to the model. This way we don't need to deal with the security, most of the time.
        if($this->isBypass(request(), config('iam.auth_bypass_uris'))){
            if(config('leo.debug.authorization_scope'))
                Log::info('[AuthorizationScope] Bypassing because URI is: ' . request()->getRequestUri());

            return;
        }

        $scope = $this->getAnonymous();

        $roles = UserHelper::getRoles();

        //  Here we are exiting if we dont have any roles. Because we don't need to apply any role to the model.
        if(!$roles) {
            $scope = $this->getAnonymous();

            if(config('leo.debug.authorization_scope'))
                Log::info('[AuthorizationScope] My user has no role. Applying: ' . get_class($scope));

            $scope->apply($builder, $model);

            return;
        }

        foreach ($roles as $role) {
            if(!$role->class) {
                UserHelper::removeFromRole($role);
                continue;
            }

            if(!class_exists($role->class)) {
                //UserHelper::removeFromRole($role);
                continue;
            }

            $role = app($role->class);

            if(config('leo.debug.authorization_scope'))
                Log::info('[AuthorizationScope] Testing our role against the model: ' . get_class($role)
                    . ' - ' . $model->getTable());

            if(config('leo.debug.authorization_scope'))
                Log::info('[AuthorizationScope] The result of' .
                    ' canBeApplied is: ' . ($role->canBeApplied($model->getTable()) === true ? 'true' : 'false'));

            if($role->canBeApplied($model->getTable())) {
                $scope = $role;

                if(config('leo.debug.authorization_scope'))
                    Log::info('[AuthorizationScope] My user has role. Applying: ' . get_class($scope));

                if($this->isRoleApplied($builder, $model)) {
                    return;
                }

                $model->setHidden([
                    'is_authorized' => true
                ]);

                if(config('leo.debug.authorization_scope'))
                    Log::info('[AuthorizationScope] Applying role: ' . get_class($scope));

                if(config('leo.debug.authorization_scope'))
                    Log::info('[AuthorizationScope] Applying to model: ' . $model->getTable());

                $scope->apply($builder, $model);
                return;
            }
        }

        if(config('leo.debug.authorization_scope'))
            Log::info('[AuthorizationScope] Seems like I cannot apply' .
                ' any role, that is why I am adding anonymous role');

        $this->getAnonymous()->apply($builder, $model);
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
        //  Here we have a bug about security, even though the builder is not there, its not applying the same
        //  builder for the second iteration.
        /*
        if($model->getHidden()) {
            //  @todo: Should be revisited
            return true;
        }
*/
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

        if(!$role->class)
            throw new \Exception('I am trying to apply the role: ' . $role->name . '. But I cannot find '
                . 'the related class for the role. That is why I cannot apply.');

        return app($role->class);
    }
}
