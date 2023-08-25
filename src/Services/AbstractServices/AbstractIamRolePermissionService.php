<?php

namespace NextDeveloper\IAM\Services\AbstractServices;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Helpers\DatabaseHelper;
use NextDeveloper\IAM\Database\Models\IamRolePermission;
use NextDeveloper\IAM\Database\Filters\IamRolePermissionQueryFilter;
use NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionCreatedEvent;
use NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionCreatingEvent;
use NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionUpdatedEvent;
use NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionUpdatingEvent;
use NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionDeletedEvent;
use NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionDeletingEvent;


/**
* This class is responsible from managing the data for IamRolePermission
*
* Class IamRolePermissionService.
*
* @package NextDeveloper\IAM\Database\Models
*/
class AbstractIamRolePermissionService {
    public static function get(IamRolePermissionQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator {
        $enablePaginate = array_key_exists('paginate', $params);

        /**
        * Here we are adding null request since if filter is null, this means that this function is called from
        * non http application. This is actually not I think its a correct way to handle this problem but it's a workaround.
        *
        * Please let me know if you have any other idea about this; baris.bulut@nextdeveloper.com
        */
        if($filter == null)
            $filter = new IamRolePermissionQueryFilter(new Request());

        $perPage = config('commons.pagination.per_page');

        if($perPage == null)
            $perPage = 20;

        if(array_key_exists('per_page', $params)) {
            $perPage = intval($params['per_page']);

            if($perPage == 0)
                $perPage = 20;
        }

        if(array_key_exists('orderBy', $params)) {
            $filter->orderBy($params['orderBy']);
        }

        $model = IamRolePermission::filter($filter);

        if($model && $enablePaginate)
            return $model->paginate($perPage);
        else
            return $model->get();
    }

    public static function getAll() {
        return IamRolePermission::all();
    }

    /**
    * This method returns the model by looking at reference id
    *
    * @param $ref
    * @return mixed
    */
    public static function getByRef($ref) : ?IamRolePermission {
        return IamRolePermission::findByRef($ref);
    }

    /**
    * This method returns the model by lookint at its id
    *
    * @param $id
    * @return IamRolePermission|null
    */
    public static function getById($id) : ?IamRolePermission {
        return IamRolePermission::where('id', $id)->first();
    }

    /**
    * This method created the model from an array.
    *
    * Throws an exception if stuck with any problem.
    *
    * @param array $data
    * @return mixed
    * @throw Exception
    */
    public static function create(array $data) {
        event( new IamRolePermissionCreatingEvent() );

                if (array_key_exists('iam_role_id', $data))
            $data['iam_role_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\IamRole',
                $data['iam_role_id']
            );
	        if (array_key_exists('iam_permission_id', $data))
            $data['iam_permission_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\IamPermission',
                $data['iam_permission_id']
            );
	        
        try {
            $model = IamRolePermission::create($data);
        } catch(\Exception $e) {
            throw $e;
        }

        event( new IamRolePermissionCreatedEvent($model) );

        return $model->fresh();
    }

    /**
    * This method updated the model from an array.
    *
    * Throws an exception if stuck with any problem.
    *
    * @param
    * @param array $data
    * @return mixed
    * @throw Exception
    */
    public static function update($id, array $data) {
        $model = IamRolePermission::where('uuid', $id)->first();

                if (array_key_exists('iam_role_id', $data))
            $data['iam_role_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\IamRole',
                $data['iam_role_id']
            );
	        if (array_key_exists('iam_permission_id', $data))
            $data['iam_permission_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\IamPermission',
                $data['iam_permission_id']
            );
	
        event( new IamRolePermissionUpdatingEvent($model) );

        try {
           $isUpdated = $model->update($data);
           $model = $model->fresh();
        } catch(\Exception $e) {
           throw $e;
        }

        event( new IamRolePermissionUpdatedEvent($model) );

        return $model->fresh();
    }

    /**
    * This method updated the model from an array.
    *
    * Throws an exception if stuck with any problem.
    *
    * @param
    * @param array $data
    * @return mixed
    * @throw Exception
    */
    public static function delete($id, array $data) {
        $model = IamRolePermission::where('uuid', $id)->first();

        event( new IamRolePermissionDeletingEvent() );

        try {
            $model = $model->delete();
        } catch(\Exception $e) {
            throw $e;
        }

        event( new IamRolePermissionDeletedEvent($model) );

        return $model;
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
