<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{

    public function __construct()
    {
        $this->model = model('App\Models\Users', false);
    }

    public function profile()
    {
        try {
            if($user = $this->model->getOne(session()->user_id)){
                $user->ignore();
                return $this->respond(array(
                    'data'  => $user
                ));
            }else{
                return $this->failNotFound();
            }
            
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}
