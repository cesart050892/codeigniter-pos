<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Categories extends BaseController
{
    public function index()
    {
        return view('pos/categories/index');
    }
}