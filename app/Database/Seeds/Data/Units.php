<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;

class Units extends Seeder
{
    public function run()
    {
        //
        $model = model('App\Models\Units', false);

        $data = [
            [
                'unit' => 'Pieza',
                'abbreviation' => 'pza.'
            ],
        ];

        foreach ($data as $result) {
            $entity = new \App\Entities\Units($result);
            $model->insert($entity);
        }
    }
}
