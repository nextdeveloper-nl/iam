<?php

namespace NextDeveloper\IAM\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use NextDeveloper\Generator\Http\Traits\Responsable;

class AbstractController extends Controller
{
//  NextDeveloper Generator Traits
use Responsable;

//  Laravel Traits
use DispatchesJobs, ValidatesRequests;
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n


}