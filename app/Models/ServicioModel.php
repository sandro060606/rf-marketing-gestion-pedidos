<?php

namespace App\Models;

use CodeIgniter\Model;

class ServicioModel extends Model
{
    protected $table      = 'servicios';        //Vincula Tabla fisica en BD
    protected $primaryKey = 'id';               //Identifica Id(PK) de la Tabla
    protected $returnType = 'array';            //Definir Datos al Recepcionar

    /**
     * Obtener solo los servicios que deben mostrarse al cliente
     * @return array Lista de arrays con los datos de cada servicio
     */
    public function listarActivos(): array
    {
        return $this->orderBy('nombre', 'ASC')->findAll();
    }
}