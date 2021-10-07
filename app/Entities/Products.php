<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\HTTP\Files\UploadedFile;

class Products extends Entity
{
    protected $path = ROOTPATH . 'public/assets/uploads/img/';
    protected $default = 'assets/img/undraw_product.png';

    protected $datamap = [];
    protected $dates   = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts   = [];

    public function getImage()
    {
        if ($this->attributes['image'] !== $this->default) {
            $this->attributes['image'] = "assets/uploads/img/products/{$this->attributes['image']}";
        }
        return $this->attributes['image'];
    }

    public function saveProfileImage(UploadedFile $image)
    {
        if (isset($this->attributes['image'])) {
            $this->deleteImage();
        }
        $name = $this->storeImage($image);
        return $name;
    }

    private function storeImage(UploadedFile $image)
    {
        if (!$image->isValid() || $image->hasMoved()) {
            return false;
        }
        try {
            $name = $image->getRandomName();
            $image->move($this->path . "products/", $name);
        } catch (\Throwable $th) {
            return false;
        }
        return $name;
    }

    public function deleteImage(): bool
    {
        if ($this->attributes['image'] !== $this->default) {
            $file    = "{$this->path}{$this->image}";
            if (!file_exists($file)) {
                return false;
            }
            return unlink($file);
        }
        return false;
    }
}
