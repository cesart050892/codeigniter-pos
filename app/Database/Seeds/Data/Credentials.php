<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;

class Credentials extends Seeder
{
    public function run()
    {
        //
        $model = model('App\Models\Credentials', false);

        $data = [
            [
                'email'         => 'admin@email.com',
                'username'      => ' admin',
                'password'      => 'admin123'
            ]
        ];

        foreach ($data as $result) {
            $model->insert($result);
        }
    }
}
