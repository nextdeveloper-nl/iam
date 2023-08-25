<?php

namespace NextDeveloper\IAM\Services\AbstractServices;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Helpers\DatabaseHelper;
use NextDeveloper\IAM\Database\Models\IamUser;
use NextDeveloper\IAM\Database\Filters\IamUserQueryFilter;
use NextDeveloper\IAM\Events\IamUser\IamUserCreatedEvent;
use NextDeveloper\IAM\Events\IamUser\IamUserCreatingEvent;
use NextDeveloper\IAM\Events\IamUser\IamUserUpdatedEvent;
use NextDeveloper\IAM\Events\IamUser\IamUserUpdatingEvent;
use NextDeveloper\IAM\Events\IamUser\IamUserDeletedEvent;
use NextDeveloper\IAM\Events\IamUser\IamUserDeletingEvent;


/**
 * This class is responsible from managing the data for IamUser
 *
 * Class IamUserService.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class AbstractIamUserService
{
    public static function get(IamUserQueryFilter $filter = null, array $params = []): Collection|LengthAwarePaginator
    {
        $enablePaginate = array_key_exists('paginate', $params);

        /**
         * Here we are adding null request since if filter is null, this means that this function is called from
         * non http application. This is actually not I think its a correct way to handle this problem but it's a workaround.
         *
         * Please let me know if you have any other idea about this; baris.bulut@nextdeveloper.com
         */
        if ($filter == null)
            $filter = new IamUserQueryFilter(new Request());

        $perPage = config('commons.pagination.per_page');

        if ($perPage == null)
            $perPage = 20;

        if (array_key_exists('per_page', $params)) {
            $perPage = intval($params['per_page']);

            if ($perPage == 0)
                $perPage = 20;
        }

        if (array_key_exists('orderBy', $params)) {
            $filter->orderBy($params['orderBy']);
        }

        $model = IamUser::filter($filter);

        if ($model && $enablePaginate)
            return $model->paginate($perPage);
        else
            return $model->get();
    }

    public static function getAll()
    {
        return IamUser::all();
    }

    /**
     * This method returns the model by looking at reference id
     *
     * @param $ref
     * @return mixed
     */
    public static function getByRef($ref): ?IamUser
    {
        return IamUser::findByRef($ref);
    }

    /**
     * This method returns the model by lookint at its id
     *
     * @param $id
     * @return IamUser|null
     */
    public static function getById($id): ?IamUser
    {
        return IamUser::where('id', $id)->first();
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
    public static function create(array $data)
    {
        event(new IamUserCreatingEvent());

        if (array_key_exists('common_language_id', $data))
            $data['common_language_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\Commons\Database\Models\CommonLanguage',
                $data['common_language_id']
            );
        if (array_key_exists('common_country_id', $data))
            $data['common_country_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\Commons\Database\Models\CommonCountry',
                $data['common_country_id']
            );

        try {
            $model = IamUser::create($data);
        } catch (\Exception $e) {
            throw $e;
        }

        event(new IamUserCreatedEvent($model));

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
    public static function update($id, array $data)
    {
        $model = IamUser::where('uuid', $id)->first();

        if (array_key_exists('common_language_id', $data))
            $data['common_language_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\Commons\Database\Models\CommonLanguage',
                $data['common_language_id']
            );
        if (array_key_exists('common_country_id', $data))
            $data['common_country_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\Commons\Database\Models\CommonCountry',
                $data['common_country_id']
            );

        event(new IamUserUpdatingEvent($model));

        try {
            $isUpdated = $model->update($data);
            $model = $model->fresh();
        } catch (\Exception $e) {
            throw $e;
        }

        CacheHelper::deleteKeys(
            'IamUser', $model->uuid
        );
        
        event(new IamUserUpdatedEvent($model));

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
    public static function delete($id, array $data)
    {
        $model = IamUser::where('uuid', $id)->first();

        event(new IamUserDeletingEvent());

        try {
            $model = $model->delete();
        } catch (\Exception $e) {
            throw $e;
        }

        event(new IamUserDeletedEvent($model));

        return $model;
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
