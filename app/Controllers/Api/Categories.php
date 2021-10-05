<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Categories extends ResourceController
{

    public function __construct()
    {
        $this->model = model('App\Models\Categories', false);
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

    public function create()
    {
        if (!$this->validate([
            'category' => 'required'
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $entity = new \App\Entities\Categories();
        $entity->fill($this->request->getPost(['category']));
        if (!$this->model->save($entity)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return $this->respondUpdated(['message' => 'ok!']);
    }

    public function delete($id = null)
    {
        try {
            $entity = $this->model->find($id);
            if ($this->model->delete($id)) {
                $this->model->purgeDeleted();
                return $this->respond(array(
                    'message'    => 'Deleted'
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
            if ($entity = $this->model->find($id)) {
                return $this->respond(array(
                    'data'    => $entity
                ));
            } else {
                return $this->failNotFound('can\'t be no found it');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }

    public function update($id = null)
    {
        try {
            //
            if ($this->validate(array(
                'category' => 'required',
            ))) {
                $entity = $this->model->find($id);
                $entity->fill($this->request->getPost(['category']));

                if ($entity->hasChanged()) {
                    if (!$this->model->save($entity)) {
                        return $this->failValidationErrors($this->model->errors());
                    }
                }

                return $this->respondUpdated(array(
                    'message' => 'updated'
                ));
            } else {
                return $this->failValidationErrors($this->validator->getErrors());
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError($th->getMessage());
        }
    }
}
