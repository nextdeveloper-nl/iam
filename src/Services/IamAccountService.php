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

    /**
     * This function creates the initial account for the given user
     *
     * @param IamUser $user
     * @return IamAccount
     * @throws \Exception
     */
    public static function createInitialAccount(IamUser $user) : IamAccount
    {
        if($user->name == '')
            $name = i18n::t('My personal account');

        $accountData = [
            'name'      =>  $name,
            'owner_id'  =>  $user->id
        ];

        return self::create($accountData);
    }

    public static function createAccount($accountName, IamUser $user) : IamAccount
    {
        $accountData = [
            'name'  =>  $accountName,
            'owner_id'  =>  $user->id
        ];

        $account = self::create($accountData);

        $relation = $user->iamAccount()->attach($account->id);

        return $account;
    }
}