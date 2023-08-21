<?php

namespace NextDeveloper\IAM\Services\AbstractServices;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Helpers\DatabaseHelper;
use NextDeveloper\IAM\Database\Models\IamRoleUser;
use NextDeveloper\IAM\Database\Filters\IamRoleUserQueryFilter;

use NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserCreatedEvent;
use NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserCreatingEvent;
use NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserUpdatedEvent;
use NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserUpdatingEvent;
use NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserDeletedEvent;
use NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserDeletingEvent;

/**
* This class is responsible from managing the data for IamRoleUser
*
* Class IamRoleUserService.
*
* @package NextDeveloper\IAM\Database\Models
*/
class AbstractIamRoleUserService {
    public static function get(IamRoleUserQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator {
        $enablePaginate = array_key_exists('paginate', $params);

        /**
        * Here we are adding null request since if filter is null, this means that this function is called from
        * non http application. This is actually not I think its a correct way to handle this problem but it's a workaround.
        *
        * Please let me know if you have any other idea about this; baris.bulut@nextdeveloper.com
        */
        if($filter == null)
            $filter = new IamRoleUserQueryFilter(new Request());

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

        $model = IamRoleUser::filter($filter);

        if($model && $enablePaginate)
            return $model->paginate($perPage);
        else
            return $model->get();
    }

    public static function getAll() {
        return IamRoleUser::all();
    }

    /**
    * This method returns the model by looking at reference id
    *
    * @param $ref
    * @return mixed
    */
    public static function getByRef($ref) : ?IamRoleUser {
        return IamRoleUser::findByRef($ref);
    }

    /**
    * This method returns the model by lookint at its id
    *
    * @param $id
    * @return IamRoleUser|null
    */
    public static function getById($id) : ?IamRoleUser {
        return IamRoleUser::where('id', $id)->first();
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
        event( new IamRoleUserCreatingEvent() );

                if (array_key_exists('iam_role_id', $data))
            $data['iam_role_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\IamRole',
                $data['iam_role_id']
            );
	        if (array_key_exists('iam_user_id', $data))
            $data['iam_user_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\IamUser',
                $data['iam_user_id']
            );
	        if (array_key_exists('iam_account_id', $data))
            $data['iam_account_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\IamAccount',
                $data['iam_account_id']
            );
	        
        try {
            $model = IamRoleUser::create($data);
        } catch(\Exception $e) {
            throw $e;
        }

        event( new IamRoleUserCreatedEvent($model) );

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
        $model = IamRoleUser::where('uuid', $id)->first();

                if (array_key_exists('iam_role_id', $data))
            $data['iam_role_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\IamRole',
                $data['iam_role_id']
            );
	        if (array_key_exists('iam_user_id', $data))
            $data['iam_user_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\IamUser',
                $data['iam_user_id']
            );
	        if (array_key_exists('iam_account_id', $data))
            $data['iam_account_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\IamAccount',
                $data['iam_account_id']
            );
	
        event( new IamRoleUserUpdatingEvent($model) );

        try {
           $model = $model->update($data);
        } catch(\Exception $e) {
           throw $e;
        }

        event( new IamRoleUserUpdatedEvent($model) );
        
        CacheHelper::deleteKeys('IamRoleUser', $id);

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
        $model = IamRoleUser::where('uuid', $id)->first();

        event( new IamRoleUserDeletingEvent() );

        try {
            $model = $model->delete();
        } catch(\Exception $e) {
            throw $e;
        }

        event( new IamRoleUserDeletedEvent($model) );
        
        CacheHelper::deleteKeys('IamRoleUser', $id);

        return $model;
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
