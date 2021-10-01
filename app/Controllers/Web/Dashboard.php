<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('pos/dashboard');
    }
}