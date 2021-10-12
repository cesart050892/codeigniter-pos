<?php

namespace App\Models;

use CodeIgniter\Model;

class Settings extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'settings';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           =  \App\Entities\Settings::class;
    protected $useSoftDeletes       = true;
    protected $protectFields        = true;
    protected $allowedFields        = ['key', 'value'];

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
    public function setSetting($key, $setting)
    {
        $old = $this->where('key', $key)->first();

        if ($old) {
            $old->value = $setting;
            if ($old->hasChange()) {
                $this->save($old);
            }
            return;
        }

        $set = new \App\Entities\Settings();
        $set->key = $key;
        $set->value = $setting;
        $this->save($set);
    }

    public function getSetting($key)
    {
        $setting = $this->where('key', $key)->first();

        if ($setting) {
            return $setting->value;
        } else {
            return null;
        }
    }
}
