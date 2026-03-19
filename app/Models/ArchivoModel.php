<?php

namespace App\Models;

use CodeIgniter\Model;

class ArchivoModel extends Model
{
    protected $table = 'archivos';      //Vincula Tabla fisica en BD
    protected $primaryKey = 'id';       //Identifica Id(PK) de la Tabla
    protected $returnType = 'array';    //Definir Datos al Recepcionar
    protected $allowedFields = [
        'idformulario',
        'idpedido',
        'nombre',
        'ruta',
        'tipo',
        'tamano',
    ];

    /**
     * Trae archivos adjuntos subidos por el cliente
     * @param int $idFormulario
     * @return array Lista de archivos de entrada
     */
    public function listarEntradas(int $idFormulario): array
    {
        return $this->where('idformulario', $idFormulario)
            ->where('tipo', 'entrada')
            ->orderBy('fechasubida', 'DESC')
            ->findAll();
    }

    /**
     * Trae los archivos finales entregados por la agencia
     * @param int $idPedido
     * @return array Lista de archivos entregables
     */
    public function listarEntregables(int $idPedido): array
    {
        return $this->where('idpedido', $idPedido)
            ->where('tipo', 'entregable')
            ->orderBy('fechasubida', 'DESC')
            ->findAll();
    }
}