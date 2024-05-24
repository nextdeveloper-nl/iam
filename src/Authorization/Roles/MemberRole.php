<?php

namespace NextDeveloper\IAM\Authorization\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use NextDeveloper\Commons\Helpers\DatabaseHelper;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Helpers\UserHelper;

class MemberRole extends AbstractRole implements IAuthorizationRole
{
    public const NAME = 'member';

    public const LEVEL = 254;

    public const DESCRIPTION = 'Member';

    public const DB_PREFIX = '*';

    /**
     * Applies basic member role sql
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        //  Adding exception here for the user model
        if($model->getTable() == 'iam_users') {
            $this->iamAccountTable($builder, $model);
            return;
        }

        $isPublicExists = DatabaseHelper::isColumnExists($model->getTable(), 'is_public');

        // TODO: Implement apply() method.
        $isAccountIdExists = DatabaseHelper::isColumnExists($model->getTable(), 'iam_account_id');
        $isUserIdExists =  DatabaseHelper::isColumnExists($model->getTable(), 'iam_user_id');

        $where = [];

        if($isAccountIdExists) {
            if(config('leo.debug.authorization_role'))
                Log::info('[MemberRole] Applying iam_account_id');

            $where[] = ['iam_account_id', UserHelper::currentAccount()->id];
            $builder->where('iam_account_id', UserHelper::currentAccount()->id);
        }

        if($isUserIdExists) {
            if(config('leo.debug.authorization_role'))
                Log::info('[MemberRole] Applying iam_user_id');

            $where[] = ['iam_user_id', UserHelper::me()->id];
            $builder->where('iam_user_id', UserHelper::me()->id);
        }

        if($isPublicExists) {
            if(config('leo.debug.authorization_role'))
                Log::info('[MemberRole] Applying is_public = true and user model');

            $builder->where('is_public', true)
                ->orWhere($where);
        } else {
            $builder->where($where);
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

    public function getModule()
    {
        return 'iam';
    }

    public function allowedOperations() :array
    {
        return [
            'iam_accounts:read',
            'iam_account_types:read',
            'iam_users:read',
            'iam_users:update',
            'iam_roles:read',
            'iam_permissions:read',
            'iam_user_roles:read',
            'iam_user_permissions:read',
            'iam_role_permissions:read',
            'iam_role_users:read',
            'iam_account_users:read',
            'iam_user_accounts:read',
            'iam_account_users:read',
            'iam_backend_directories:read'
        ];
    }

    public function canBeApplied($column)
    {
        if(self::DB_PREFIX === '*') {
            return true;
        }

        if(Str::startsWith($column, self::DB_PREFIX)) {
            return true;
        }

        return parent::canBeApplied($column); // TODO: Change the autogenerated stub
    }

    public function getDbPrefix()
    {
        return self::DB_PREFIX;
    }

    public function checkRules(Users $users): bool
    {
        // TODO: Implement checkRules() method.
    }
}
