<?php

namespace NextDeveloper\IAM\Http\Controllers\Authentication;

use NextDeveloper\IAM\Http\Controllers\AbstractController;
use NextDeveloper\IAM\Services\LoginMechanismsService;

class MechanismsController extends AbstractController
{
    public function index()
    {
        return $this->withArray(LoginMechanismsService::getLoginMechanisms());
    }
}
