<?php

namespace NextDeveloper\IAM\Services;

use NextDeveloper\IAM\Services\AbstractServices\AbstractLoginMechanismsService;

/**
* This class is responsible from managing the data for LoginMechanisms
*
* Class LoginMechanismsService.
*
* @package NextDeveloper\IAM\Database\Models
*/
class LoginMechanismsService extends AbstractLoginMechanismsService {

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
    public static function getByUser(IamUser $user) : Collection
    {
        $mechanisms = IamLoginMechanism::where('iam_user_id', $user->id)
            ->get();

        return $mechanisms;
    }
}