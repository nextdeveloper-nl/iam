<?php

namespace NextDeveloper\IAM\Services\AbstractServices;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Helpers\DatabaseHelper;
use NextDeveloper\IAM\Database\Models\IamAccountType;
use NextDeveloper\IAM\Database\Filters\IamAccountTypeQueryFilter;
use NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeCreatedEvent;
use NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeCreatingEvent;
use NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeUpdatedEvent;
use NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeUpdatingEvent;
use NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeDeletedEvent;
use NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeDeletingEvent;


/**
* This class is responsible from managing the data for IamAccountType
*
* Class IamAccountTypeService.
*
* @package NextDeveloper\IAM\Database\Models
*/
class AbstractIamAccountTypeService {
    public static function get(IamAccountTypeQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator {
        $enablePaginate = array_key_exists('paginate', $params);

        /**
        * Here we are adding null request since if filter is null, this means that this function is called from
        * non http application. This is actually not I think its a correct way to handle this problem but it's a workaround.
        *
        * Please let me know if you have any other idea about this; baris.bulut@nextdeveloper.com
        */
        if($filter == null)
            $filter = new IamAccountTypeQueryFilter(new Request());

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

        $model = IamAccountType::filter($filter);

        if($model && $enablePaginate)
            return $model->paginate($perPage);
        else
            return $model->get();
    }

    public static function getAll() {
        return IamAccountType::all();
    }

    /**
    * This method returns the model by looking at reference id
    *
    * @param $ref
    * @return mixed
    */
    public static function getByRef($ref) : ?IamAccountType {
        return IamAccountType::findByRef($ref);
    }

    /**
    * This method returns the model by lookint at its id
    *
    * @param $id
    * @return IamAccountType|null
    */
    public static function getById($id) : ?IamAccountType {
        return IamAccountType::where('id', $id)->first();
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
        event( new IamAccountTypeCreatingEvent() );

                if (array_key_exists('common_country_id', $data))
            $data['common_country_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\Commons\Database\Models\CommonCountry',
                $data['common_country_id']
            );
	        
        try {
            $model = IamAccountType::create($data);
        } catch(\Exception $e) {
            throw $e;
        }

        event( new IamAccountTypeCreatedEvent($model) );

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
        $model = IamAccountType::where('uuid', $id)->first();

                if (array_key_exists('common_country_id', $data))
            $data['common_country_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\Commons\Database\Models\CommonCountry',
                $data['common_country_id']
            );
	
        event( new IamAccountTypeUpdatingEvent($model) );

        try {
           $isUpdated = $model->update($data);
           $model = $model->fresh();
        } catch(\Exception $e) {
           throw $e;
        }

        event( new IamAccountTypeUpdatedEvent($model) );

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
        $model = IamAccountType::where('uuid', $id)->first();

        event( new IamAccountTypeDeletingEvent() );

        try {
            $model = $model->delete();
        } catch(\Exception $e) {
            throw $e;
        }

        event( new IamAccountTypeDeletedEvent($model) );

        return $model;
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
