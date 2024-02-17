<?php

namespace NextDeveloper\IAM\Authorization\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SystemAdminRole extends AbstractRole implements IAuthorizationRole
{
    public const NAME = 'system-admin';

    public const LEVEL = 100;

    public const DESCRIPTION = 'System Administrator';

    public const DB_PREFIX = '*';

    public function apply(Builder $builder, Model $model)
    {
        // TODO: Implement apply() method.
    }

    public function getModule()
    {
        return 'iam';
    }

    public function allowedOperations() :array
    {
        return [
            '*:*'
        ];
    }

    public function canBeApplied($column) : bool
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
