<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\Roles;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class RolesTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractRolesTransformer extends AbstractTransformer
{

    /**
     * @param Roles $model
     *
     * @return array
     */
    public function transform(Roles $model)
    {
            
        return $this->buildPayload(
            [
            'id'  =>  $model->uuid,
            'name'  =>  $model->name,
            'class'  =>  $model->class,
            'level'  =>  $model->level,
            'description'  =>  $model->description,
            'created_at'  =>  $model->created_at,
            'updated_at'  =>  $model->updated_at,
            'deleted_at'  =>  $model->deleted_at,
            ]
        );
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n





























}
