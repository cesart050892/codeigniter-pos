<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Purchases extends ResourceController
{

    public function __construct()
    {
        $this->model = model('App\Models\Purchases', false);
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
            'code'  => 'required',
            'stock' => 'required',
            'description'   => 'required',
            'cost'  => 'required',
            'sale'  => 'required',
            'category' => 'required'
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $entity = new \App\Entities\Products();
        $entity->fill($this->request->getPost([
            'code',
            'stock',
            'description',
            'cost',
            'sale'
        ]));
        $entity->category_fk = $this->request->getPost('category');
        if ($file = $this->request->getFile('image')) {
            if ($this->validate([
                "image" => 'is_image[image]|max_size[image,1024]' 
            ])) {
                if ($file->isValid()) {
                    if (!$new = $entity->saveProfileImage($file)) {
                        return $this->failValidationErrors('Image is no valid!');
                    }
                    $entity->image = $new;
                }
            }
        }
        if (!$this->model->save($entity)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return $this->respondCreated(['message' => 'ok!']);
    }

    public function update($id = null)
    {
        if (!$this->validate([
            'stock' => 'required',
            'description'   => 'required',
            'cost'  => 'required',
            'sale'  => 'required',
            'category' => 'required'
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $entity = new \App\Entities\Products();
        $entity->fill($this->request->getPost([
            'stock',
            'description',
            'cost',
            'sale'
        ]));
        $entity->category_fk = $this->request->getPost('category');
        $entity->id = $id;
        if ($file = $this->request->getFile('image')) {
            if ($this->validate([
                "image" => 'is_image[image]|max_size[image,1024]' 
            ])) {
                if ($file->isValid()) {
                    if (!$new = $entity->saveProfileImage($file)) {
                        return $this->failValidationErrors('Image is no valid!');
                    }
                    $entity->image = $new;
                }
            }
        }
        if (!$this->model->save($entity)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return $this->respondUpdated(['message' => 'ok!']);
    }
}
