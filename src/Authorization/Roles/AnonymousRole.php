<?php

namespace NextDeveloper\IAM\Authorization\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use NextDeveloper\Commons\Helpers\DatabaseHelper;
use NextDeveloper\IAM\Database\Models\Users;

class AnonymousRole extends AbstractRole implements IAuthorizationRole, RoleToElasticFilterInterface
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

    /**
     * ES counterpart of apply() - mirrors it field-for-field. See apply() for the DB
     * version this must stay in sync with.
     */
    public function toElasticFilter(Model $modelInstance): ?array
    {
        $isPublicExists = DatabaseHelper::isColumnExists($modelInstance->getTable(), 'is_public');

        if ($isPublicExists) {
            return ['term' => ['is_public' => true]];
        }

        $isAccountIdExists = DatabaseHelper::isColumnExists($modelInstance->getTable(), 'iam_account_id');
        $isUserIdExists = DatabaseHelper::isColumnExists($modelInstance->getTable(), 'iam_user_id');

        $mustNot = [];

        if ($isAccountIdExists) {
            $mustNot[] = ['exists' => ['field' => 'iam_account_id']];
        }

        if ($isUserIdExists) {
            $mustNot[] = ['exists' => ['field' => 'iam_user_id']];
        }

        return $mustNot ? ['bool' => ['must_not' => $mustNot]] : null;
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
}
