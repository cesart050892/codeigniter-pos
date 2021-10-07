<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Units extends ResourceController
{

    public function __construct()
    {
        $this->model = model('App\Models\Units', false);
    }

    public function index()
    {
        try {
            $response = $this->model->findAll();
            return $this->respond(array(
                'data'  => $response
            ));
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }


    public function delete($id = null)
    {
        try {
            if ($this->model->delete($id)) {
                $this->model->purgeDeleted();
                return $this->respond(array(
                    'message'    => 'deleted'
                ));
            } else {
                return $this->fail($this->model->errors());
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }

    public function edit($id = null)
    {
        try {
            if ($response = $this->model->find($id)) {
                return $this->respond(array(
                    'data'    => $response
                ));
            } else {
                return $this->fail($this->model->errors());
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }

    public function create()
    {
        if (!$this->validate([
            'unit'  => 'required',
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $entity = new \App\Entities\Products();
        $entity->fill($this->request->getPost([
            'unit',
            'abbreviation'
        ]));
        if (!$this->model->save($entity)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return $this->respondCreated(['message' => 'ok!']);
    }

    public function update($id = null)
    {
        if (!$this->validate([
            'unit'  => 'required',
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $entity = new \App\Entities\Products();
        $entity->fill($this->request->getPost([
            'unit',
            'abbreviation'
        ]));
        $entity->id = $id;
        if (!$this->model->save($entity)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return $this->respondUpdated(['message' => 'ok!']);
    }
}
