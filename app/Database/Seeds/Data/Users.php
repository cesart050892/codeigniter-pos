<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        //
        $model = model('App\Models\Users', false);

        $data = [
            [
                'name'              => 'Cesar A.',
                'surname'           => 'Tapia',
                'address'           => 'Managua',
                'state'             => 1,
                'rol_fk'            => 1,
                'credential_fk'     => 1
            ]
        ];

        foreach ($data as $result) {
            $model->insert($result);
        }
    }
}
