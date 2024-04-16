<?php

namespace NextDeveloper\IAM\Helpers;

use Illuminate\Support\Facades\DB;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Services\RolesService;
use NextDeveloper\IAM\Services\UsersService;

class RoleHelper
{

    /**
     * Get user by role name.
     *
     * This method retrieves the user with the specified role name.
     *
     * @param string $roleName The name of the role.
     * @return Users|null The user with the specified role, or null if not found.
     * @throws \Exception If role or user is not found.
     */
    public static function getUserByRoleName(string $roleName): ?Users
    {

        $role = RolesService::getRoleByName($roleName);
        if (!$role) {
            logger()->error("$roleName role not found");
            throw new \Exception("$roleName role not found");
        }

        $userRole = DB::table('iam_role_user')
            ->where('iam_role_id', $role->id)
            ->first();

        if (!$userRole) {
            logger()->error("$roleName user not found");
            throw new \Exception("$roleName user not found");
        }

        return UsersService::getById($userRole->iam_user_id);
    }


}
