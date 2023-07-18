<?php

namespace NextDeveloper\IAM\Authorization\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MemberRole extends AbstractRole implements IAuthorizationRole
{
    public const NAME = 'member';

    public const LEVEL = 255;

    public function apply(Builder $builder, Model $model)
    {
        // TODO: Implement apply() method.
    }
}