<?php

namespace App\Models;

use CodeIgniter\Model;

class Products extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'products';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = \App\Entities\Products::class;
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'code',
        'image',
        'stock',
        'description',
        'cost',
        'sale',
        'quantity',
        'category_fk'
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
            products.id, 
            products.`code`, 
            products.description, 
            products.stock, 
            products.cost, 
            products.sale, 
            products.quantity, 
            products.image, 
            products.category_fk, 
            categories.category, 
            products.created_at, 
            products.updated_at, 
            products.deleted_at
		')
            ->join('categories', 'products.category_fk = categories.id')
            ->findAll();
    }

    public function getOne($id)
    {
        return $this->select('
            products.id, 
            products.`code`, 
            products.description, 
            products.stock, 
            products.cost, 
            products.sale, 
            products.quantity, 
            products.image, 
            products.category_fk, 
            categories.category, 
            products.created_at, 
            products.updated_at, 
            products.deleted_at
        ')
            ->join('categories', 'products.category_fk = categories.id')
            ->where('products.id', $id)
            ->first();
    }
}
