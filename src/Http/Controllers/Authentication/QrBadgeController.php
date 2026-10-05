<?php

namespace NextDeveloper\IAM\Http\Controllers\Authentication;

use NextDeveloper\IAM\AuthenticationGrants\QrBadge;
use NextDeveloper\IAM\Authorization\Roles\IamAdminRole;
use NextDeveloper\IAM\Authorization\Roles\SystemAdminRole;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Helpers\ResponseHelper;
use NextDeveloper\IAM\Helpers\UserHelper;
use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\IAM\Http\Requests\Authentication\QrBadgeRequest;

class QrBadgeController extends AbstractController
{
    /**
     * Issues (or re-issues) the QR sign-in badge of a user. The badge content is returned
     * only in this response; re-issuing invalidates the previous badge.
     */
    public function issue($userId, QrBadgeRequest $request)
    {
        $user = $this->authorizedUser($userId);

        return ResponseHelper::data([
            'badge' => QrBadge::issue($user),
            'name' => trim(($user->name ?? '').' '.($user->surname ?? '')),
            'username' => $user->username,
        ]);
    }

    /**
     * Revokes the QR sign-in badge of a user.
     */
    public function revoke($userId, QrBadgeRequest $request)
    {
        $user = $this->authorizedUser($userId);

        return ResponseHelper::data([
            'revoked' => QrBadge::revoke($user),
        ]);
    }

    /**
     * Only the roles in iam.qr_badge_admin_roles may manage another user's badge.
     */
    private function authorizedUser($userId): Users
    {
        $allowedRoles = config('iam.qr_badge_admin_roles', [IamAdminRole::NAME, SystemAdminRole::NAME]);

        if (! collect($allowedRoles)->contains(fn ($role) => UserHelper::hasRole($role))) {
            abort(403, 'Only administrators can manage the sign-in badge of a user.');
        }

        $user = UserHelper::getWithId($userId);

        if (! $user) {
            abort(404, 'User not found.');
        }

        return $user;
    }
}
