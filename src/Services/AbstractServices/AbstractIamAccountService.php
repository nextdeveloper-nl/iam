<?php

namespace NextDeveloper\IAM\Services\AbstractServices;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use NextDeveloper\IAM\Database\Models\IamAccount;
use NextDeveloper\IAM\Database\Filters\IamAccountQueryFilter;

use NextDeveloper\IAM\Events\IamAccount\IamAccountCreatedEvent;
use NextDeveloper\IAM\Events\IamAccount\IamAccountCreatingEvent;
use NextDeveloper\IAM\Events\IamAccount\IamAccountUpdatedEvent;
use NextDeveloper\IAM\Events\IamAccount\IamAccountUpdatingEvent;
use NextDeveloper\IAM\Events\IamAccount\IamAccountDeletedEvent;
use NextDeveloper\IAM\Events\IamAccount\IamAccountDeletingEvent;

/**
* This class is responsible from managing the data for IamAccount
*
* Class IamAccountService.
*
* @package NextDeveloper\IAM\Database\Models
*/
class AbstractIamAccountService {
    public static function get(IamAccountQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator {
        $enablePaginate = array_key_exists('paginate', $params);

        /**
        * Here we are adding null request since if filter is null, this means that this function is called from
        * non http application. This is actually not I think its a correct way to handle this problem but it's a workaround.
        *
        * Please let me know if you have any other idea about this; baris.bulut@nextdeveloper.com
        */
        if($filter == null)
            $filter = new IamAccountQueryFilter(new Request());

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

        $model = IamAccount::filter($filter);

        if($model && $enablePaginate)
            return $model->paginate($perPage);
        else
            return $model->get();

        if(!$model && $enablePaginate)
            return IamAccount::paginate($perPage);
        else
            return IamAccount::get();
    }

    public static function getAll() {
        return IamAccount::all();
    }

    /**
    * This method returns the model by looking at reference id
    *
    * @param $ref
    * @return mixed
    */
    public static function getByRef($ref) : ?IamAccount {
        return IamAccount::findByRef($ref);
    }

    /**
    * This method returns the model by lookint at its id
    *
    * @param $id
    * @return IamAccount|null
    */
    public static function getById($id) : ?IamAccount {
        return IamAccount::where('id', $id)->first();
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
        event( new IamAccountCreatingEvent() );

        try {
            $model = IamAccount::create($data);
        } catch(\Exception $e) {
            throw $e;
        }

        event( new IamAccountCreatedEvent($model) );

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
        $model = IamAccount::where('uuid', $id)->first();

        event( new IamAccountsUpdateingEvent($model) );

        try {
           $model = $model->update($data);
        } catch(\Exception $e) {
           throw $e;
        }

        event( new IamAccountsUpdatedEvent($model) );

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
        $model = IamAccount::where('uuid', $id)->first();

        event( new IamAccountsDeletingEvent() );

        try {
            $model = $model->delete();
        } catch(\Exception $e) {
            throw $e;
        }

        event( new IamAccountsDeletedEvent($model) );

        return $model;
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}