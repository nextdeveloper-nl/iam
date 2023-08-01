<?php

namespace NextDeveloper\IAM\Services;

use Illuminate\Database\Eloquent\Collection;
use NextDeveloper\IAM\Database\Models\IamLoginMechanism;
use NextDeveloper\IAM\Database\Models\IamUser;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamLoginMechanismService;

/**
* This class is responsible from managing the data for IamLoginMechanism
*
* Class IamLoginMechanismService.
*
* @package NextDeveloper\IAM\Database\Models
*/
class IamLoginMechanismService extends AbstractIamLoginMechanismService {

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
    public static function getByUser(IamUser $user) : Collection
    {
        $mechanisms = IamLoginMechanism::where('user_id', $user->id)
            ->get();

        return $mechanisms;
    }
}