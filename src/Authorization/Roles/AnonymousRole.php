<?php

namespace NextDeveloper\IAM\Authorization\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use NextDeveloper\Commons\Helpers\DatabaseHelper;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Helpers\UserHelper;

class AnonymousRole extends AbstractRole implements IAuthorizationRole
{
    public const NAME = 'anonymous';

    public const LEVEL = 255;

    public const DESCRIPTION = 'Anonymous User';

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
        $isPublicExists = DatabaseHelper::isColumnExists($model->getTable(), 'is_public');

        if($isPublicExists) {
            $builder->where('is_public', true);
        } else {
            // TODO: Implement apply() method.
            $isAccountIdExists = DatabaseHelper::isColumnExists($model->getTable(), 'iam_account_id');
            $isUserIdExists =  DatabaseHelper::isColumnExists($model->getTable(), 'iam_user_id');

            if($isAccountIdExists) {
                $builder->whereNull('iam_account_id');
            }

            if($isUserIdExists) {
                $builder->whereNull('iam_user_id');
            }
        }
    }

    public function getModule()
    {
        return 'iam';
    }

    public function allowedOperations() :array
    {
        return [
            'iam_users:read'
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

        return false;
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
