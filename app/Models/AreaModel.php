<?php

namespace App\Models;

use CodeIgniter\Model;

class AreaModel extends Model
{
    protected $table      = 'areas';
    protected $primaryKey = 'id';

    /**
     * Retorna todas las áreas activas del sistema.
     *
     * @return array Lista de áreas con estado activo
     */
    public function obtenerActivas(): array
    {
        return $this->where('activo', true)->findAll();
    }
}