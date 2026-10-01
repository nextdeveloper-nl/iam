<?php

namespace NextDeveloper\IAM\Http\Controllers\Authentication;

use NextDeveloper\IAM\Authorization\Roles\IamAdminRole;
use NextDeveloper\IAM\Authorization\Roles\SystemAdminRole;
use NextDeveloper\IAM\Helpers\ResponseHelper;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\IAM\Http\Requests\Authentication\PasswordSetRequest;
use NextDeveloper\IAM\Http\Requests\Authentication\PasswordUpdateRequest;
use NextDeveloper\IAM\Services\Authentication\PasswordService;

class PasswordController extends AbstractController
{
    /**
     * Changes the password of the signed in user. The token is checked by the form request.
     */
    public function updatePassword(PasswordUpdateRequest $request)
    {
        PasswordService::updatePassword(
            password: $request->validated('password'),
            currentPassword: $request->validated('current_password')
        );

        return ResponseHelper::data(['updated' => true]);
    }

    /**
     * Sets the password of another user. Only for the roles in iam.password_admin_roles.
     */
    public function setPassword($userId, PasswordSetRequest $request)
    {
        $allowedRoles = config('iam.password_admin_roles', [IamAdminRole::NAME, SystemAdminRole::NAME]);

        if (!collect($allowedRoles)->contains(fn ($role) => UserHelper::hasRole($role))) {
            abort(403, 'Only administrators can set the password of a user.');
        }

        $user = UserHelper::getWithId($userId);

        if (!$user) {
            abort(404, 'User not found.');
        }

        $givenPassword = $request->validated('password');

        $password = PasswordService::setPassword($user, $givenPassword);

        return ResponseHelper::data([
            'updated'   => true,
            //  A generated password is shown only in this response; it is not stored in plain text.
            'password'  => $givenPassword ? null : $password,
        ]);
    }
}
