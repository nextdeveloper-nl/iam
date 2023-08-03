<?php

namespace NextDeveloper\IAM\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Services\IamRoleService;

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
        //  This scope works for automated filtering of model requests. By using this global scope we have the
        //  capability to inject sql to the model. This way we dont need to deal with the security, most of the time.
        $user = UserHelper::me();
        $account = UserHelper::currentAccount();

        //  We are getting the highest level role of user.
        $role = IamRoleService::getUserRole($user, $account);

        $scope = app($role->class);

        $scope->apply($builder, $model);
    }
}