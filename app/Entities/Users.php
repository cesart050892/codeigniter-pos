<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\HTTP\Files\UploadedFile;

class Users extends Entity
{

    protected $path = ROOTPATH . 'public/';

    protected $datamap = [];
    protected $dates   = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts   = [];

    public function ignore()
    {
        unset($this->attributes['password']);
        return $this;
    }

    public function setName(string $name)
    {
        $this->attributes['name'] = ucwords($name);
        return $this;
    }

    public function setSurname(string $surname)
    {
        $this->attributes['surname'] = ucwords($surname);
        return $this;
    }

    public function getPhoto()
    {
        if ($this->attributes['photo'] !== 'assets/img/undraw_profile_2.svg') {
            $this->attributes['photo'] = "assets/uploads/img/users/{$this->attributes['photo']}";
        }
        return $this->attributes['photo'];
    }

    public function saveProfileImage(UploadedFile $image)
    {
        $image = $this->storeImage($image);
        if (isset($this->attributes['photo'])) 
        {
            $this->deleteImage();
        }
        return $image;
    }

    private function storeImage(UploadedFile $image)
    {
        if (!$image->isValid() || $image->hasMoved()) {
            return false;
        }
        try {
            $newName = $image->getRandomName();
            $image->move($this->path."assets/uploads/img/users", $newName);
            log_message("info", $newName . " saved to public upload folder");
        } catch (\Throwable $th) {
            return false;
        }
        return $newName;
    }

    public function deleteImage(): bool
    {
        if ($this->attributes['photo'] !== 'assets/img/undraw_profile_2.svg') 
        {
            $file    = "{$this->path}{$this->photo}";
            if (!file_exists($file)) {
                return false;
            }
            return unlink($file);
        }
        return false;
    }
}
