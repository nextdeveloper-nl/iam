<?php

namespace NextDeveloper\IAM\Authorization\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Helpers\DatabaseHelper;
use NextDeveloper\IAM\Helpers\UserHelper;

class MemberRole extends AbstractRole implements IAuthorizationRole
{
    public const NAME = 'member';

    public const LEVEL = 255;

    /**
     * Applies basic member role sql
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // TODO: Implement apply() method.
        $isAccountIdExists = DatabaseHelper::isColumnExists($model->getTable(), 'iam_account_id');
        $isUserIdExists =  DatabaseHelper::isColumnExists($model->getTable(), 'iam_user_id');

        if($isAccountIdExists) {
            $builder->where('iam_account_id', UserHelper::currentAccount()->id);
        }

        if($isUserIdExists) {
            $builder->where('iam_user_id', UserHelper::me()->id);
        }
    }
}