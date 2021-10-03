<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Rols extends ResourceController
{

    public function __construct()
    {
        $this->model = model('App\Models\Rols', false);
    }

    public function index()
    {
        try {
            if($response = $this->model->findAll()){
                return $this->respond(array(
                    'data'  => $response
                ));
            }else{
                return $this->failNotFound();
            }
            
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}
