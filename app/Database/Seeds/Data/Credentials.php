<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;
use Config\App;

class Credentials extends Seeder
{
    public function run()
    {
        //
        $model = model('App\Models\Credentials', false);

        $data = [
            [
                'email'         => 'admin@email.com',
                'username'      => 'admin',
                'password'      => 'admin'
            ]
        ];

        foreach ($data as $result) {
            $entity = new \App\Entities\Credentials($result);
            $model->insert($entity);
        }
    }
}
