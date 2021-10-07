<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Units extends BaseController
{
    public function index()
    {
        return view('pos/units/index');
    }
}
