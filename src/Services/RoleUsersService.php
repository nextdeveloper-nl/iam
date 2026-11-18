<?php

namespace NextDeveloper\IAM\Services;

use NextDeveloper\IAM\Services\AbstractServices\AbstractRoleUsersService;

/**
 * This class is responsible from managing the data for RoleUsers
 *
 * Class RoleUsersService.
 *
 * @package NextDeveloper\IAM\Database\Models
 */
class RoleUsersService extends AbstractRoleUsersService
{

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    //  Roles like system-viewer must never be assigned through the API (create or update)
    public static function create(array $data)
    {
        RolesService::assertAssignable($data['iam_role_id'] ?? null);

        return parent::create($data);
    }

    public static function update($id, array $data)
    {
        RolesService::assertAssignable($data['iam_role_id'] ?? null);

        return parent::update($id, $data);
    }
}