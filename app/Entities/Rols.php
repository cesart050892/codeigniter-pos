<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Rols extends Entity
{
    protected $datamap = [];
    protected $dates   = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts   = [];

    public function setRol(string $name){
        $this->attributes['rol'] = ucwords($name);
		return $this;
	}
}
