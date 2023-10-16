<?php

namespace NextDeveloper\IAM\Services;

use Illuminate\Database\Eloquent\Collection;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Services\AbstractServices\AbstractLoginMechanismsService;
use NextDeveloper\IAM\Services\LoginMechanisms\AbstractLogin;
use NextDeveloper\IAM\Services\LoginMechanisms\OneTimeEmail;

/**
* This class is responsible from managing the data for LoginMechanisms
*
* Class LoginMechanismsService.
*
* @package NextDeveloper\IAM\Database\Models
*/
class LoginMechanismsService extends AbstractLoginMechanismsService {

    private $_user;

    public function __construct(Users $user)
    {
        $this->_user = $user;
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
    public function getByUser() : Collection
    {
        $mechanisms = LoginMechanisms::where('iam_user_id', $this->_user->id)
            ->where('is_active', 1)
            ->get();

        if(!count($mechanisms))
            (new OneTimeEmail())->create($this->_user);

        $mechanisms = LoginMechanisms::where('iam_user_id', $this->_user->id)
            ->where('is_active', 1)
            ->get();

        return $mechanisms;
    }

    public function getMechanismByName($mechanism) : ?LoginMechanisms {
        foreach ($this->getByUser() as $lm) {
            if($lm->login_mechanism == $mechanism)
                return $lm;
        }

        return null;
    }

    public function getTwoFA() : ?LoginMechanisms {
        return LoginMechanisms::where('iam_user_id', $this->_user->id)
            ->where('login_mechanism', 'like', '2FA*')
            ->where('is_latest', 1)
            ->where('is_active', 1)
            ->first();
    }
}