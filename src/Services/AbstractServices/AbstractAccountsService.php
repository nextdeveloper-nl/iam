<?php

namespace NextDeveloper\IAM\Services\AbstractServices;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use NextDeveloper\Events\Services\Events;
use NextDeveloper\Commons\Helpers\DatabaseHelper;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Filters\AccountsQueryFilter;
use NextDeveloper\Commons\Exceptions\ModelNotFoundException;

/**
 * This class is responsible from managing the data for Accounts
 *
 * Class AccountsService.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class AbstractAccountsService
{
    public static function get(AccountsQueryFilter $filter = null, array $params = []) : Collection|LengthAwarePaginator
    {
        $enablePaginate = array_key_exists('paginate', $params);

        /**
        * Here we are adding null request since if filter is null, this means that this function is called from
        * non http application. This is actually not I think its a correct way to handle this problem but it's a workaround.
        *
        * Please let me know if you have any other idea about this; baris.bulut@nextdeveloper.com
        */
        if($filter == null) {
            $filter = new AccountsQueryFilter(new Request());
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

        $model = Accounts::filter($filter);

        if($model && $enablePaginate) {
            return $model->paginate($perPage);
        } else {
            return $model->get();
        }
    }

    public static function getAll()
    {
        return Accounts::all();
    }

    /**
     * This method returns the model by looking at reference id
     *
     * @param  $ref
     * @return mixed
     */
    public static function getByRef($ref) : ?Accounts
    {
        return Accounts::findByRef($ref);
    }

    /**
     * This method returns the model by lookint at its id
     *
     * @param  $id
     * @return Accounts|null
     */
    public static function getById($id) : ?Accounts
    {
        return Accounts::where('id', $id)->first();
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
            $obj = Accounts::where('uuid', $uuid)->first();

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
        if (array_key_exists('common_domain_id', $data)) {
            $data['common_domain_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\Commons\Database\Models\Domains',
                $data['common_domain_id']
            );
        }
        if (array_key_exists('common_country_id', $data)) {
            $data['common_country_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\Commons\Database\Models\Countries',
                $data['common_country_id']
            );
        }
        if (array_key_exists('iam_user_id', $data)) {
            $data['iam_user_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\Users',
                $data['iam_user_id']
            );
        }
        if (array_key_exists('iam_account_type_id', $data)) {
            $data['iam_account_type_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\AccountTypes',
                $data['iam_account_type_id']
            );
        }

        try {
            $model = Accounts::create($data);
        } catch(\Exception $e) {
            throw $e;
        }

        Events::fire('created:NextDeveloper\IAM\Accounts', $model);

        return $model->fresh();
    }

    /**
     * This function expects the ID inside the object.
     *
     * @param  array $data
     * @return Accounts
     */
    public static function updateRaw(array $data) : ?Accounts
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
        $model = Accounts::where('uuid', $id)->first();

        if (array_key_exists('common_domain_id', $data)) {
            $data['common_domain_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\Commons\Database\Models\Domains',
                $data['common_domain_id']
            );
        }
        if (array_key_exists('common_country_id', $data)) {
            $data['common_country_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\Commons\Database\Models\Countries',
                $data['common_country_id']
            );
        }
        if (array_key_exists('iam_user_id', $data)) {
            $data['iam_user_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\Users',
                $data['iam_user_id']
            );
        }
        if (array_key_exists('iam_account_type_id', $data)) {
            $data['iam_account_type_id'] = DatabaseHelper::uuidToId(
                '\NextDeveloper\IAM\Database\Models\AccountTypes',
                $data['iam_account_type_id']
            );
        }

        event(new AccountsUpdatingEvent($model));

        try {
            $isUpdated = $model->update($data);
            $model = $model->fresh();
        } catch(\Exception $e) {
            throw $e;
        }

        Events::fire('updated:NextDeveloper\IAM\Accounts', $model);

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
        $model = Accounts::where('uuid', $id)->first();

        Events::fire('deleted:NextDeveloper\IAM\Accounts', $model);

        try {
            $model = $model->delete();
        } catch(\Exception $e) {
            throw $e;
        }

        return $model;
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

}
