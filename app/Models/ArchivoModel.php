<?php

namespace App\Models;

use CodeIgniter\Model;

class ArchivoModel extends Model
{
    protected $table      = 'archivos';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'idformulario',
        'idpedido',
        'nombre',
        'ruta',
        'tipo',
        'tamano',
    ];

    // GET: Archivos de entrada de un formulario (Cliente)
    public function listarEntradas(int $idFormulario): array
    {
        return $this->where('idformulario', $idFormulario)
            ->where('tipo', 'entrada')
            ->orderBy('fechasubida', 'DESC')
            ->findAll();
    }

    // GET: Entregables de un pedido (Empleado)
    public function listarEntregables(int $idPedido): array
    {
        return $this->where('idpedido', $idPedido)
            ->where('tipo', 'entregable')
            ->orderBy('fechasubida', 'DESC')
            ->findAll();
    }

    // POST: Subir archivo de entrada (al crear formulario)
    public function subirEntrada(int $idFormulario, string $nombre, string $ruta, int $tamano): int
    {
        $this->insert([
            'idformulario' => $idFormulario,
            'idpedido'     => null,
            'nombre'       => $nombre,
            'ruta'         => $ruta,
            'tipo'         => 'entrada',
            'tamano'       => $tamano,
        ]);
        return $this->getInsertID();
    }

    // POST: Subir entregable (empleado sube el resultado)
    public function subirEntregable(int $idPedido, string $nombre, string $ruta, int $tamano): int
    {
        $this->insert([
            'idformulario' => null,
            'idpedido'     => $idPedido,
            'nombre'       => $nombre,
            'ruta'         => $ruta,
            'tipo'         => 'entregable',
            'tamano'       => $tamano,
        ]);
        return $this->getInsertID();
    }
}