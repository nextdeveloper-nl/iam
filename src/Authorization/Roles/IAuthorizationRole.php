<?php

namespace NextDeveloper\IAM\Authorization\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface IAuthorizationRole
{
    /**
     * @var string
     */
    public const NAME = '';

    /**
     * @var integer 1-255; 1 is highest, 255 is lowest.
     */
    public const LEVEL = 100;

    public function apply(Builder $builder, Model $model);
}