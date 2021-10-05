<?php

namespace App\Controllers\Api;

use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{

    public function __construct()
    {
        $this->model = model('App\Models\Credentials', false);
    }

    public function login()
    {
        //
        try {
            $rules_income = [ // Rules validations
                'username' => 'required',
                'password' => 'required|min_length[4]', //validate_user[username,password]
            ];
            if ($this->validate($rules_income)) { // Execute validation
                $data = $this->request->getPost(['username', 'password']);
                $user = $this->model->getWhere('username', $data['username']);
                if ($user->state != 1) {
                    return $this->failValidationErrors('not access');
                } else {
                    if ($user == null) return $this->fail('This user no exist!');
                    if (password_verify($data['password'], $user->password)) { // Verify password
                        $session_data = [ // Session data
                            'user_name' => $user->name,
                            'user_username' => $user->username,
                            'user_id' => $user->id,
                            'isLoggedIn' => true
                        ];
                        $userModel = model('App\Models\Users',false);
                        $userModel->save([
                            'id'            => $user->id,
                            'last_login'    => new Time('now')
                        ]);
                        session()->set($session_data);
                        return $this->respond([
                            'status' => 200,
                            'message' => 'logged in',
                            'data' => [
                                'username' => $user->username,
                                'name' =>  $user->name,
                                'created_at' => $user->created_at->humanize(),
                            ]
                        ], 200);
                    } else {
                        return $this->failValidationErrors('Invalid password');
                    }
                }
            } else {
                return $this->fail($this->validator->getErrors());
            }
        } catch (\Throwable $e) {
            //throw $e;
            return $this->failServerError($e->getMessage());
        }
    }

    public function logout()
    {
        try {
            $session = session();
            $session->destroy();
            return $this->respond(array(
                'status'    => 200,
                'message'    => 'See you next time!',
                'data'        => null
            ));
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }
}
