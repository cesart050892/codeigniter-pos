<?php

namespace App\Controllers\Web\Auth;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {
        return view('pos/auth/login');
    }
}