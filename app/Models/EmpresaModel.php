<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table      = 'empresas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['idusuario','nombreempresa','ruc','correo','telefono'];

    // Trae todas las empresas con el nombre correcto de columna
    public function obtenerTodas(): array
    {
        return $this->select('id, nombreempresa, ruc, correo, telefono')
                    ->findAll();
    }
}