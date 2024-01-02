<?php

namespace NextDeveloper\IAM\Authorization\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SystemAdminRole extends AbstractRole implements IAuthorizationRole
{
    public const NAME = 'system-admin';

    public const LEVEL = 1;

    public function apply(Builder $builder, Model $model)
    {
        // TODO: Implement apply() method.
    }
}