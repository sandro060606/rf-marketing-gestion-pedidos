<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table      = 'pedidos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['idformpedido','idadmin','idempleado','idservicio','titulo','prioridad','estado','num_modificaciones','observacion_revision','fechainicio','fechafin','fechacompletado','cancelacionmotivo'];

    // Cuenta pedidos por estado
public function contarPorEstado(string $estado): int
{
    return $this->where('estado', $estado)->countAllResults();
}

public function contarSinAsignar(): int
{
    return $this->where('idempleado', null)
                ->where('estado', 'por_aprobar')
                ->countAllResults();
}
}