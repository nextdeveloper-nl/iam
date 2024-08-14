<?php

namespace NextDeveloper\IAM\Authorization\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use NextDeveloper\Commons\Database\GlobalScopes\LimitScope;
use NextDeveloper\IAM\Database\Models\UserAccounts;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Helpers\UserHelper;

/**
 * This role is created for partners and CRM users to be able to help the customer to make certain actions. That is why
 * Iam success manager has only right to make read operations and simple write operations like updating the account object.
 */
class IamSuccessManagerRole extends AbstractRole implements IAuthorizationRole
{
    public const NAME = 'iam-success-manager';

    public const LEVEL = 120;

    public const DESCRIPTION = 'Success manager role for IAM module';

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
        //  This role is basicly a replica of Member Role. That is why we are calling the MemberRole here.
        $myAccounts = UserAccounts::withoutGlobalScope(AuthorizationScope::class)
            ->withoutGlobalScope(LimitScope::class)
            ->where('iam_user_id', UserHelper::me()->id)
            ->pluck('iam_account_id');

        if($model->getTable() == 'iam_accounts') {
            $builder->whereIn('id', $myAccounts);
        }
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
