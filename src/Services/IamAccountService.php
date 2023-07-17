<?php

namespace NextDeveloper\IAM\Services;

use NextDeveloper\IAM\Services\AbstractServices\AbstractIamAccountService;

/**
* This class is responsible from managing the data for IamAccount
*
* Class IamAccountService.
*
* @package NextDeveloper\IAM\Database\Models
*/
class IamAccountService extends AbstractIamAccountService {

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    public static function createForUser(User $user) : Account
    {
        if($user->name == '')
            $name = 'My personal account';

        $accountData = [
            'name'      =>  $name,
            'owner_id'  =>  $user->id
        ];

        return self::create($accountData);
    }
}