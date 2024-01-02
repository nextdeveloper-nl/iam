<?php

namespace NextDeveloper\IAM\Authorization\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use NextDeveloper\Commons\Helpers\DatabaseHelper;
use NextDeveloper\IAM\Helpers\UserHelper;

class MemberRole extends AbstractRole implements IAuthorizationRole
{
    public const NAME = 'member';

    public const LEVEL = 254;

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

        if($model->getTable() == 'iam_users') {
            $this->iamAccountTable($builder, $model);
            return;
        }

        if($isAccountIdExists) {
            Log::info('[MemberRole] Applying iam_account_id');
            $builder->where('iam_account_id', UserHelper::currentAccount()->id);
        }

        if($isUserIdExists) {
            Log::info('[MemberRole] Applying iam_user_id');
            $builder->where('iam_user_id', UserHelper::me()->id);
        }
    }

    /**
     * This only runs when the user is trying to reach its own accounts, or the accounts that he wants to reach
     *
     * With this filter, he can only reach to accounts;
     * - owned by him
     * - accounts that he is in
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function iamAccountTable(Builder $builder, Model $model)
    {

    }

    /**
     * He only reached to users which are in the same team as they are. But user sees all people in all teams.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function iamUserTable(Builder $builder, Model $model)
    {

    }
}