<?php

namespace NextDeveloper\IAM\Authorization\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Log;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Helpers\UserHelper;

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

        //  Not checking the policy
        if(in_array('!' . $operation, $this->allowedOperations())) {
            return true;
        }

        if(!in_array($operation, $this->allowedOperations())) {
            Log::warning('[AbstractRole@checkReadPolicy] My user can not do this operation: '
                . $operation . ' with this role: ' . get_class($this));
            return false;
        }

        return true;
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

        //  Not checking the policy
        if(in_array('!' . $operation, $this->allowedOperations())) {
            return true;
        }

        if(!in_array($operation, $this->allowedOperations())) {
            Log::warning('[AbstractRole@checkCreatePolicy] My user can not do this operation: '
                . $operation . ' with this role: ' . get_class($this));
            return false;
        }

        return true;
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

        //  Not checking the policy
        if(in_array('!' . $operation, $this->allowedOperations())) {
            return true;
        }

        if(!in_array($operation, $this->allowedOperations())) {
            Log::warning('[AbstractRole@checkUpdatePolicy] My user can not do this operation: '
                . $operation . ' with this role: ' . get_class($this));
            return false;
        }

        if(!$model->iam_account_id) {
            return true;
        }

        $isAllowed = $model->iam_account_id == UserHelper::currentAccount()->id;

        if(!$isAllowed) {
            Log::warning('[AbstractRole@checkUpdatePolicy] My user can not do this operation: '
                . $operation . ' with this role: ' . get_class($this) . '. Its because you dont own this object: ' . $model->uuid);
        }

        return $isAllowed;
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

        //  Not checking the policy
        if(in_array('!' . $operation, $this->allowedOperations())) {
            return true;
        }

        if(!in_array($operation, $this->allowedOperations())) {
            Log::warning('[AbstractRole@checkUpdatePolicy] My user can not do this operation: ' . $operation
                . ' with this role: ' . get_class($this));
            return false;
        }

        $isAllowed = $model->iam_account_id == UserHelper::currentAccount()->id;

        if(!$isAllowed) {
            Log::warning('[AbstractRole@checkUpdatePolicy] My user can not do this operation: '
                . $operation . ' with this role: ' . get_class($this) . '. Its because you dont own this object: ' . $model->uuid);
        }

        return $isAllowed;
    }
}
