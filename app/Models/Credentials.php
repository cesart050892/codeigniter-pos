<?php

namespace App\Models;

use CodeIgniter\Model;

class Credentials extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'credentials';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = \App\Entities\Credentials::class;
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['email', 'username', 'password'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'username'  => 'required|is_unique[credentials.username,id,{id}]',
        'email'     => 'required|valid_email|is_unique[credentials.email,id,{id}]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    // Functions

    public function getWhere(string $field, string $value){
        return $this->select('	
            credentials.email,
            credentials.username,
            credentials.`password`,
            credentials.created_at,
            credentials.updated_at,
            credentials.deleted_at,
            users.`name`,
            users.surname,
            users.photo,
            users.address,
            users.phone,
            users.state,
            users.last_login,
            users.credential_fk,
            users.rol_fk,
            rols.rol,
            users.id '
        )
        ->join('users', 'credentials.id = users.credential_fk')
        ->join('rols', 'users.rol_fk = rols.id')
        ->where($field, $value)
        ->first();
    }
}
