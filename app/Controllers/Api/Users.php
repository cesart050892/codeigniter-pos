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
            if ($user = $this->model->getOne(session()->user_id)) {
                $user->ignore();
                return $this->respond(array(
                    'data'  => $user
                ));
            } else {
                return $this->failNotFound();
            }
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function index()
    {
        try {
            if ($users = $this->model->getAll()) {
                return $this->respond(array(
                    'data'  => $users
                ));
            } else {
                return $this->failNotFound();
            }
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function create()
    {
        if (!$this->validate([
            'name' => 'required'
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $user = new \App\Entities\Users();
        if ($file = $this->request->getFile('image')) {
            if ($this->validate([
                "image" => 'is_image[image]|max_size[image,1024]' // moidifique el JS para aceptar pdf y testear la validacion
            ])) {
                if ($file->isValid()) { // el usuario cambio la imagen
                    if (!$newImage = $user->saveProfileImage($file)) {
                        return $this->failValidationErrors('Image is no valid!');
                    }
                    $user->photo = $newImage;
                }
            }
        }
        $authModel = model('App\Models\Credentials', false);
        $auth = new \App\Entities\Credentials($this->request->getPost(['email', 'username', 'password']));

        if (!$authModel->save($auth)) {
            return $this->failValidationErrors($authModel->errors());
        }

        $user->credential_fk = $authModel->insertID();
        $user->state = $this->request->getPost('state') ? $this->request->getPost('state') : 1;
        $user = $user->fill($this->request->getPost(['name', 'rol_fk']));

        if (!$this->model->save($user)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return $this->respondUpdated(['message' => 'ok!']);
    }

    public function delete($id = null)
    {
        try {
            $user = $this->model->find($id);
            $user->deleteImage();
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
            if ($resp = $this->model->getOne($id)) {
                $resp->ignore();
                return $this->respond(array(
                    'data'    => $resp
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
                'name' => 'required',
            ))) {
                $user = $this->model->getOne($id);
                $user->fill($this->request->getPost(['surname', 'name', 'email', 'rol_fk']));
                $user->state = $this->request->getPost('state') ? $this->request->getPost('state') : 1;

                if ($file = $this->request->getFile('image')) {
                    if ($this->validate([
                        "image" => 'is_image[image]|max_size[image,1024]' // moidifique el JS para aceptar pdf y testear la validacion
                    ])) {
                        if ($file->isValid()) { // el usuario cambio la imagen
                            if (!$newImage = $user->saveProfileImage($file)) {
                                return $this->failValidationErrors('Image is no valid!');
                            }
                            $user->photo = $newImage;
                        }
                    }
                }

                $authModel = model('App\Models\Credentials', false);
                $auth = $authModel->find($user->credential_fk);

                $auth->fill($this->request->getPost(['email', 'username']));

                $password = $this->request->getPost('password');
                if ($password) $auth->fill($password);

                if ($auth->hasChanged()) {
                    if (!$authModel->save($auth)) {
                        return $this->failValidationErrors($authModel->errors());
                    }
                }
                if ($user->hasChanged()) {
                    if (!$this->model->save($user)) {
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

    public function state($id = null)
    {
        try {
            //
            if ($this->validate(array(
                'state' => 'required',
            ))) {
                $user = $this->model->getOne($id);
                if ($id  != session()->user_id) {
                    $user->fill($this->request->getPost(['state']));

                    if ($user->hasChanged()) {
                        if (!$this->model->save($user)) {
                            return $this->failValidationErrors($this->model->errors());
                        }
                    }

                    return $this->respondUpdated(array(
                        'message' => 'updated'
                    ));
                }else{
                    return $this->failValidationErrors('not allowed');
                }
            } else {
                return $this->failValidationErrors($this->validator->getErrors());
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError($th->getMessage());
        }
    }
}
