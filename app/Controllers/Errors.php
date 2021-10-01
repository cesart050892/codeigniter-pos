<?php

namespace App\Controllers;

class Errors extends BaseController
{
    public function index()
    {
        echo view('errors/404');
    }
}
