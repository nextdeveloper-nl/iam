<?php

namespace NextDeveloper\IAM\Http\Transformers\AbstractTransformers;

use NextDeveloper\IAM\Database\Models\IamPermission;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;

/**
 * Class IamPermissionTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AbstractIamPermissionTransformer extends AbstractTransformer {

    /**
     * @param IamPermission $model
     *
     * @return array
     */
    public function transform(IamPermission $model) {
                
        return $this->buildPayload([
'id'  =>  $model->uuid,
'namespace'  =>  $model->namespace,
'service'  =>  $model->service,
'method'  =>  $model->method,
'name'  =>  $model->name,
'is_active'  =>  $model->is_active == 1 ? true : false,
'created_by'  =>  $model->created_by,
'updated_by'  =>  $model->updated_by,
'created_at'  =>  $model->created_at,
'updated_at'  =>  $model->updated_at,
    ]);
    }
    
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n


}
