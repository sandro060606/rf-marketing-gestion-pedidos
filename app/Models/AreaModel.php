<?php

namespace App\Models;

use CodeIgniter\Model;

class AreaModel extends Model
{
    protected $table      = 'areas';
    protected $primaryKey = 'id';

    public function obtenerActivas(): array
    {
        return $this->where('activo', true)->findAll();
    }
}