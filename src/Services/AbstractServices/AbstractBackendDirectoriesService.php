<?php

namespace NextDeveloper\IAM\Services\AbstractServices;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Helpers\DatabaseHelper;
use NextDeveloper\IAM\Database\Models\BackendDirectories;
use NextDeveloper\IAM\Database\Filters\BackendDirectoriesQueryFilter;
use NextDeveloper\Commons\Exceptions\ModelNotFoundException;
use NextDeveloper\IAM\Events\BackendDirectories\BackendDirectoriesCreatedEvent;
use NextDeveloper\IAM\Events\BackendDirectories\BackendDirectoriesCreatingEvent;
use NextDeveloper\IAM\Events\BackendDirectories\BackendDirectoriesUpdatedEvent;
use NextDeveloper\IAM\Events\BackendDirectories\BackendDirectoriesUpdatingEvent;
use NextDeveloper\IAM\Events\BackendDirectories\BackendDirectoriesDeletedEvent;
use NextDeveloper\IAM\Events\BackendDirectories\BackendDirectoriesDeletingEvent;

/**
 * This class is responsible from managing the data for BackendDirectories
 *
 * Class BackendDirectoriesService.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class AbstractBackendDirectoriesService
{
    public static function get(BackendDirectoriesQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator
    {
        $enablePaginate = array_key_exists('paginate', $params);

        /**
        * Here we are adding null request since if filter is null, this means that this function is called from
        * non http application. This is actually not I think its a correct way to handle this problem but it's a workaround.
        *
        * Please let me know if you have any other idea about this; baris.bulut@nextdeveloper.com
        */
        if($filter == null) {
            $filter = new BackendDirectoriesQueryFilter(new Request());
        }

        $perPage = config('commons.pagination.per_page');

        if($perPage == null) {
            $perPage = 20;
        }

        if(array_key_exists('per_page', $params)) {
            $perPage = intval($params['per_page']);

            if($perPage == 0) {
                $perPage = 20;
            }
        }

        if(array_key_exists('orderBy', $params)) {
            $filter->orderBy($params['orderBy']);
        }

        $model = BackendDirectories::filter($filter);

        if($model && $enablePaginate) {
            return $model->paginate($perPage);
        } else {
            return $model->get();
        }
    }

    public static function getAll()
    {
        return BackendDirectories::all();
    }

    /**
     * This method returns the model by looking at reference id
     *
     * @param  $ref
     * @return mixed
     */
    public static function getByRef($ref) : ?BackendDirectories
    {
        return BackendDirectories::findByRef($ref);
    }

    /**
     * This method returns the model by lookint at its id
     *
     * @param  $id
     * @return BackendDirectories|null
     */
    public static function getById($id) : ?BackendDirectories
    {
        return BackendDirectories::where('id', $id)->first();
    }

    /**
     * This method returns the sub objects of the related models
     *
     * @param  $uuid
     * @param  $object
     * @return void
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public static function relatedObjects($uuid, $object)
    {
        try {
            $obj = BackendDirectories::where('uuid', $uuid)->first();

            if(!$obj) {
                throw new ModelNotFoundException('Cannot find the related model');
            }

            if($obj) {
                return $obj->$object;
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * This method created the model from an array.
     *
     * Throws an exception if stuck with any problem.
     *
     * @param  array $data
     * @return mixed
     * @throw  Exception
     */
    public static function create(array $data)
    {
        event(new BackendDirectoriesCreatingEvent());

        if (array_key_exists('iam_account_id', $data)) {
            $data['iam_account_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\Accounts',
                $data['iam_account_id']
            );
        }
        if (array_key_exists('iaas_virtual_machine_id', $data)) {
            $data['iaas_virtual_machine_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAAS\Database\Models\VirtualMachines',
                $data['iaas_virtual_machine_id']
            );
        }
    
        try {
            $model = BackendDirectories::create($data);
        } catch(\Exception $e) {
            throw $e;
        }

        event(new BackendDirectoriesCreatedEvent($model));

        return $model->fresh();
    }

    /**
     This function expects the ID inside the object.
    
     @param  array $data
     @return BackendDirectories
     */
    public static function updateRaw(array $data) : ?BackendDirectories
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
     * @param  array $data
     * @return mixed
     * @throw  Exception
     */
    public static function update($id, array $data)
    {
        $model = BackendDirectories::where('uuid', $id)->first();

        if (array_key_exists('iam_account_id', $data)) {
            $data['iam_account_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\Accounts',
                $data['iam_account_id']
            );
        }
        if (array_key_exists('iaas_virtual_machine_id', $data)) {
            $data['iaas_virtual_machine_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAAS\Database\Models\VirtualMachines',
                $data['iaas_virtual_machine_id']
            );
        }
    
        event(new BackendDirectoriesUpdatingEvent($model));

        try {
            $isUpdated = $model->update($data);
            $model = $model->fresh();
        } catch(\Exception $e) {
            throw $e;
        }

        event(new BackendDirectoriesUpdatedEvent($model));

        return $model->fresh();
    }

    /**
     * This method updated the model from an array.
     *
     * Throws an exception if stuck with any problem.
     *
     * @param
     * @param  array $data
     * @return mixed
     * @throw  Exception
     */
    public static function delete($id)
    {
        $model = BackendDirectories::where('uuid', $id)->first();

        event(new BackendDirectoriesDeletingEvent());

        try {
            $model = $model->delete();
        } catch(\Exception $e) {
            throw $e;
        }

        return $model;
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
