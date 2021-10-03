<?php

namespace App\Controllers;

class Errors extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            echo view('errors/views/isnt_logged_404');
        } else {
            echo view('errors/views/is_logged_404');
        }
    }
}
