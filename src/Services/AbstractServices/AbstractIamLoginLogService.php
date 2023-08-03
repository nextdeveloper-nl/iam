<?php

namespace NextDeveloper\IAM\Services\AbstractServices;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use NextDeveloper\IAM\Database\Models\IamLoginLog;
use NextDeveloper\IAM\Database\Filters\IamLoginLogQueryFilter;

use NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogCreatedEvent;
use NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogCreatingEvent;
use NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogUpdatedEvent;
use NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogUpdatingEvent;
use NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogDeletedEvent;
use NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogDeletingEvent;

/**
* This class is responsible from managing the data for IamLoginLog
*
* Class IamLoginLogService.
*
* @package NextDeveloper\IAM\Database\Models
*/
class AbstractIamLoginLogService {
    public static function get(IamLoginLogQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator {
        $enablePaginate = array_key_exists('paginate', $params);

        /**
        * Here we are adding null request since if filter is null, this means that this function is called from
        * non http application. This is actually not I think its a correct way to handle this problem but it's a workaround.
        *
        * Please let me know if you have any other idea about this; baris.bulut@nextdeveloper.com
        */
        if($filter == null)
            $filter = new IamLoginLogQueryFilter(new Request());

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

        $model = IamLoginLog::filter($filter);

        if($model && $enablePaginate)
            return $model->paginate($perPage);
        else
            return $model->get();

        if(!$model && $enablePaginate)
            return IamLoginLog::paginate($perPage);
        else
            return IamLoginLog::get();
    }

    public static function getAll() {
        return IamLoginLog::all();
    }

    /**
    * This method returns the model by looking at reference id
    *
    * @param $ref
    * @return mixed
    */
    public static function getByRef($ref) : ?IamLoginLog {
        return IamLoginLog::findByRef($ref);
    }

    /**
    * This method returns the model by lookint at its id
    *
    * @param $id
    * @return IamLoginLog|null
    */
    public static function getById($id) : ?IamLoginLog {
        return IamLoginLog::where('id', $id)->first();
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
        event( new IamLoginLogCreatingEvent() );

        try {
            $model = IamLoginLog::create($data);
        } catch(\Exception $e) {
            throw $e;
        }

        event( new IamLoginLogCreatedEvent($model) );

        return $model;
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
        $model = IamLoginLog::where('uuid', $id)->first();

        event( new IamLoginLogsUpdateingEvent($model) );

        try {
           $model = $model->update($data);
        } catch(\Exception $e) {
           throw $e;
        }

        event( new IamLoginLogsUpdatedEvent($model) );

        return $model;
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
        $model = IamLoginLog::where('uuid', $id)->first();

        event( new IamLoginLogsDeletingEvent() );

        try {
            $model = $model->delete();
        } catch(\Exception $e) {
            throw $e;
        }

        event( new IamLoginLogsDeletedEvent($model) );

        return $model;
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}