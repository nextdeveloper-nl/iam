<?php

namespace NextDeveloper\IAM\Services\AbstractServices;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Helpers\DatabaseHelper;
use NextDeveloper\IAM\Database\Models\RolePermissions;
use NextDeveloper\IAM\Database\Filters\RolePermissionsQueryFilter;
use NextDeveloper\IAM\Events\RolePermissions\RolePermissionsCreatedEvent;
use NextDeveloper\IAM\Events\RolePermissions\RolePermissionsCreatingEvent;
use NextDeveloper\IAM\Events\RolePermissions\RolePermissionsUpdatedEvent;
use NextDeveloper\IAM\Events\RolePermissions\RolePermissionsUpdatingEvent;
use NextDeveloper\IAM\Events\RolePermissions\RolePermissionsDeletedEvent;
use NextDeveloper\IAM\Events\RolePermissions\RolePermissionsDeletingEvent;


/**
* This class is responsible from managing the data for RolePermissions
*
* Class RolePermissionsService.
*
* @package NextDeveloper\IAM\Database\Models
*/
class AbstractRolePermissionsService {
    public static function get(RolePermissionsQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator {
        $enablePaginate = array_key_exists('paginate', $params);

        /**
        * Here we are adding null request since if filter is null, this means that this function is called from
        * non http application. This is actually not I think its a correct way to handle this problem but it's a workaround.
        *
        * Please let me know if you have any other idea about this; baris.bulut@nextdeveloper.com
        */
        if($filter == null)
            $filter = new RolePermissionsQueryFilter(new Request());

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

        $model = RolePermissions::filter($filter);

        if($model && $enablePaginate)
            return $model->paginate($perPage);
        else
            return $model->get();
    }

    public static function getAll() {
        return RolePermissions::all();
    }

    /**
    * This method returns the model by looking at reference id
    *
    * @param $ref
    * @return mixed
    */
    public static function getByRef($ref) : ?RolePermissions {
        return RolePermissions::findByRef($ref);
    }

    /**
    * This method returns the model by lookint at its id
    *
    * @param $id
    * @return RolePermissions|null
    */
    public static function getById($id) : ?RolePermissions {
        return RolePermissions::where('id', $id)->first();
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
        event( new RolePermissionsCreatingEvent() );

                if (array_key_exists('iam_role_id', $data))
            $data['iam_role_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\Roles',
                $data['iam_role_id']
            );
	        if (array_key_exists('iam_permission_id', $data))
            $data['iam_permission_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\Permissions',
                $data['iam_permission_id']
            );
	        
        try {
            $model = RolePermissions::create($data);
        } catch(\Exception $e) {
            throw $e;
        }

        event( new RolePermissionsCreatedEvent($model) );

        return $model->fresh();
    }

/**
* This function expects the ID inside the object.
*
* @param array $data
* @return RolePermissions
*/
public static function updateRaw(array $data) : ?RolePermissions
{
if(array_key_exists('id', $data)) {
return self::update($data['id'], $data);
}

return null;
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
        $model = RolePermissions::where('uuid', $id)->first();

                if (array_key_exists('iam_role_id', $data))
            $data['iam_role_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\Roles',
                $data['iam_role_id']
            );
	        if (array_key_exists('iam_permission_id', $data))
            $data['iam_permission_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\Permissions',
                $data['iam_permission_id']
            );
	
        event( new RolePermissionsUpdatingEvent($model) );

        try {
           $isUpdated = $model->update($data);
           $model = $model->fresh();
        } catch(\Exception $e) {
           throw $e;
        }

        event( new RolePermissionsUpdatedEvent($model) );

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
        $model = RolePermissions::where('uuid', $id)->first();

        event( new RolePermissionsDeletingEvent() );

        try {
            $model = $model->delete();
        } catch(\Exception $e) {
            throw $e;
        }

        event( new RolePermissionsDeletedEvent($model) );

        return $model;
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
