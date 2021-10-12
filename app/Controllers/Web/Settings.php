<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Settings extends BaseController
{
    public function index()
    {
        return view('pos/settings');
    }
}
