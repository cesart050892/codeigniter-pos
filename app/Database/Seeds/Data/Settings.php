<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;

class Settings extends Seeder
{
    public function run()
    {
        //
        $model = model('App\Models\Settings', false);

        $data = [
            [
                'key'           =>'app_name' ,
                'value'         => 'Tienda JFU-MR'
            ],
            [
                'key'           =>'app_ruc' ,
                'value'         => 'XX00XX1010AA'
            ],
            [
                'key'           =>'app_phone' ,
                'value'         => '22552255'
            ],
            [
                'key'           =>'app_email' ,
                'value'         => 'acce@email.com'
            ],
            [
                'key'           =>'app_address' ,
                'value'         => 'Managua, Nicaragua'
            ],
            [
                'key'           =>'app_slogan' ,
                'value'         => 'Gracias por comprar'
            ],
        ];

        foreach ($data as $result) {
            $entity = new \App\Entities\Settings($result);
            $model->insert($entity);
        }
    }
}
