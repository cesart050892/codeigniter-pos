<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Products extends ResourceController
{

    public function __construct()
    {
        $this->model = model('App\Models\Products', false);
    }

    public function index()
    {
        try {
            $response = $this->model->getAll();
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
            if ($response = $this->model->getOne($id)) {
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
        if($last = $this->model->getLast()){
            $number = intval($last->id) + 1;
            $entity->code =  substr(strtoupper($last->category), 0, 3).$number;
        }else{
            $model = model('App\Models\Categories',false);
            $category = $model->where('id', $this->request->getPost('category'))->first();
            $entity->code =  substr(strtoupper($category->category), 0, 3)."1";
        }
        $entity->category_fk = $this->request->getPost('category');
        $entity->unit_fk = $this->request->getPost('unit');
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
        $entity->unit_fk = $this->request->getPost('unit');
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
