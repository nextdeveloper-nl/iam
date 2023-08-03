<?php

namespace NextDeveloper\IAM\Services\AbstractServices;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use NextDeveloper\IAM\Database\Models\IamLoginMechanism;
use NextDeveloper\IAM\Database\Filters\IamLoginMechanismQueryFilter;

use NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismCreatedEvent;
use NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismCreatingEvent;
use NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismUpdatedEvent;
use NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismUpdatingEvent;
use NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismDeletedEvent;
use NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismDeletingEvent;

/**
* This class is responsible from managing the data for IamLoginMechanism
*
* Class IamLoginMechanismService.
*
* @package NextDeveloper\IAM\Database\Models
*/
class AbstractIamLoginMechanismService {
    public static function get(IamLoginMechanismQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator {
        $enablePaginate = array_key_exists('paginate', $params);

        /**
        * Here we are adding null request since if filter is null, this means that this function is called from
        * non http application. This is actually not I think its a correct way to handle this problem but it's a workaround.
        *
        * Please let me know if you have any other idea about this; baris.bulut@nextdeveloper.com
        */
        if($filter == null)
            $filter = new IamLoginMechanismQueryFilter(new Request());

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

        $model = IamLoginMechanism::filter($filter);

        if($model && $enablePaginate)
            return $model->paginate($perPage);
        else
            return $model->get();

        if(!$model && $enablePaginate)
            return IamLoginMechanism::paginate($perPage);
        else
            return IamLoginMechanism::get();
    }

    public static function getAll() {
        return IamLoginMechanism::all();
    }

    /**
    * This method returns the model by looking at reference id
    *
    * @param $ref
    * @return mixed
    */
    public static function getByRef($ref) : ?IamLoginMechanism {
        return IamLoginMechanism::findByRef($ref);
    }

    /**
    * This method returns the model by lookint at its id
    *
    * @param $id
    * @return IamLoginMechanism|null
    */
    public static function getById($id) : ?IamLoginMechanism {
        return IamLoginMechanism::where('id', $id)->first();
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
        event( new IamLoginMechanismCreatingEvent() );

        try {
            $model = IamLoginMechanism::create($data);
        } catch(\Exception $e) {
            throw $e;
        }

        event( new IamLoginMechanismCreatedEvent($model) );

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
        $model = IamLoginMechanism::where('uuid', $id)->first();

        event( new IamLoginMechanismsUpdateingEvent($model) );

        try {
           $model = $model->update($data);
        } catch(\Exception $e) {
           throw $e;
        }

        event( new IamLoginMechanismsUpdatedEvent($model) );

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
        $model = IamLoginMechanism::where('uuid', $id)->first();

        event( new IamLoginMechanismsDeletingEvent() );

        try {
            $model = $model->delete();
        } catch(\Exception $e) {
            throw $e;
        }

        event( new IamLoginMechanismsDeletedEvent($model) );

        return $model;
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}