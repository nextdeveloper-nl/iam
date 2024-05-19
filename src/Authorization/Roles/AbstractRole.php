<?php

namespace NextDeveloper\IAM\Authorization\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Log;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Helpers\UserHelper;
use PhpParser\Node\Expr\AssignOp\Mod;
use function Laravel\Prompts\warning;

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

    public function checkAsd()
    {
        return true;
    }

    /**
     * This function checks if the user has the privilege to perform the operation
     *
     * @param $method
     * @param Model $model
     * @param Users $user
     * @return void
     */
    public function checkPolicy($method, Model $model, Users $user) : bool
    {
        if($method == 'save') {
            if($model->exists) {
                $method = 'update';
            } else {
                $method = 'create';
            }
        }

        switch ($method) {
            case 'read':
                return $this->checkReadPolicy($user, $model);
                break;
            case 'create':
                return $this->checkCreatePolicy($user, $model);
                break;
            case 'update':
                return $this->checkUpdatePolicy($model, $user);
                break;
            case 'delete':
                return $this->checkDeletePolicy($model, $user);
                break;
        }

        return false;
    }

    public function checkReadPolicy(Users $user, Model $model) : bool
    {
        $operation = $model->getTable() . ':read';

        if(in_array($operation, $this->allowedOperations())) {
            Log::info('[AbstractRole@checkReadPolicy] My user can do this operation: ' . $operation);
            return true;
        }

        return false;
    }

    /**
     * This function checks if the user has the privilege to perform the create operation
     *
     * @param Model $model
     * @param Users $user
     * @return void
     */
    public function checkCreatePolicy(Users $user, Model $model) : bool
    {
        $operation = $model->getTable() . ':create';

        if(in_array($operation, $this->allowedOperations())) {
            Log::info('[AbstractRole@checkCreatePolicy] My user can do this operation: ' . $operation);
            return true;
        }

        return false;
    }

    /**
     * Default policy for related updating the related model is to own the model.
     *
     * @param Model $model
     * @param Users $user
     * @return bool
     */
    public function checkUpdatePolicy(Model $model, Users $user) : bool
    {
        $operation = $model->getTable() . ':update';

        if(!in_array($operation, $this->allowedOperations())) {
            Log::info('[AbstractRole@checkUpdatePolicy] My user can do this operation: ' . $operation);
            return false;
        }

        return $model->iam_account_id == UserHelper::currentAccount()->id;
    }

    /**
     * Default policy to delete the model is to own the model
     *
     * @param Model $model
     * @param Users $user
     * @return bool
     */
    public function checkDeletePolicy(Model $model, Users $user) : bool
    {
        $operation = $model->getTable() . ':delete';

        if(!in_array($operation, $this->allowedOperations())) {
            Log::info('[AbstractRole@checkUpdatePolicy] My user can do this operation: ' . $operation);
            return false;
        }

        return $model->iam_account_id == UserHelper::currentAccount()->id;
    }
}
