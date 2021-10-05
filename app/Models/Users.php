<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'users';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = \App\Entities\Users::class;
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'name',
        'surname',
        'photo',
        'address',
        'phone',
        'state',
        'credential_fk',
        'rol_fk',
        'last_login'
    ];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [];
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

    public function getAll()
    {
        return $this->select('
            users.id,
            users.`name`,
            users.surname,
            users.photo,
            users.address,
            users.last_login,
            users.phone,
            users.state,
            users.credential_fk,
            credentials.email,
            credentials.username,
            users.rol_fk,
            rols.rol,
            users.created_at,
            users.updated_at,
            users.deleted_at 
			')
            ->join('credentials', 'users.credential_fk = credentials.id')
            ->join('rols', 'users.rol_fk = rols.id')
            ->findAll();
            }

    public function getOne($id)
    {
        return $this->select('
                users.id,
                users.`name`,
                users.surname,
                users.photo,
                users.address,
                users.phone,
                users.state,
                users.credential_fk,
                credentials.email,
                credentials.username,
                credentials.`password`,
                users.rol_fk,
                rols.rol,
                users.created_at,
                users.updated_at,
                users.deleted_at 
			')
            ->join('credentials', 'users.credential_fk = credentials.id')
            ->join('rols', 'users.rol_fk = rols.id')
            ->where('users.id', $id)
            ->first();
    }
}
