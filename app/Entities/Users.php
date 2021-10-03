<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Users extends Entity
{
    protected $datamap = [];
    protected $dates   = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts   = [];

    public function ignore(){
		unset($this->attributes['password']);
		return $this;
	}

    public function setName(string $name){
        $this->attributes['name'] = ucwords($name);
		return $this;
	}

    public function setSurname(string $surname){
        $this->attributes['surname'] = ucwords($surname);
		return $this;
	}
}
