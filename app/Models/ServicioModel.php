<?php

namespace App\Models;

use CodeIgniter\Model;

class ServicioModel extends Model
{
    protected $table      = 'servicios';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    // Lista todos los servicios activos
    public function listarActivos(): array
    {
        return $this->orderBy('nombre', 'ASC')->findAll();
    }
}