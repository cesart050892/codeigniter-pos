<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Products extends BaseController
{
    public function index()
    {
        return view('pos/products/index');
    }
}