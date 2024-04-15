<?php

namespace NextDeveloper\IAM\Authorization\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use NextDeveloper\IAM\Database\Models\Users;

class AbstractRole implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        //  We will not apply any scope here
    }

    public function canBeApplied($column)
    {
        return false;
    }

    public function allowedObjects() {
        $operations = $this->allowedOperations();

        $objects = [];

        foreach ($operations as $operation) {
            $object = explode(':', $operation)[0];

            if(!in_array($object, $objects))
                $objects[] = $object;
        }

        return $objects;
    }

    public function checkRoles(Users $users) {
        return true;
    }
}
