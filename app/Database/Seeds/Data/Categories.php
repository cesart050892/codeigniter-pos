<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;

class Categories extends Seeder
{
    public function run()
    {
        //
        $model = model('App\Models\Categories', false);

        $data = [
            ['category' => 'Bebidas'],
        ];

        foreach ($data as $result) {
            $entity = new \App\Entities\Categories($result);
            $model->insert($entity);
        }
    }
}
