<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table      = 'pedidos';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    // ─────────────────────────────────────────────────────────
    // GET: Lista de pedidos de un cliente
    //
    // El cliente ve sus pedidos a través de su empresa.
    // Se filtra por el idusuario del cliente (representante
    // de la empresa) y se trae estado, servicio y fechas.
    // ─────────────────────────────────────────────────────────
    public function listarPorCliente(int $idUsuario): array
    {
        return $this->db->table('pedidos p')
            ->select('
                p.id,
                p.titulo,
                p.estado,
                p.prioridad,
                p.fechacreacion,
                p.fechainicio,
                p.fechafin,
                p.num_modificaciones,
                s.nombre  AS servicio,
                e.nombreempresa AS empresa
            ')
            ->join('servicios s',           's.id = p.idservicio')
            ->join('formulario_pedidos fp', 'fp.id = p.idformpedido')
            ->join('empresas e',            'e.id = fp.idempresa')
            ->where('e.idusuario', $idUsuario) // Solo pedidos de su empresa
            ->orderBy('p.fechacreacion', 'DESC')
            ->get()
            ->getResultArray();
    }

    // ─────────────────────────────────────────────────────────
    // GET: Detalle completo de un pedido
    //
    // Trae toda la info del pedido + datos del formulario
    // original que envió el cliente (descripción, formatos,
    // canales, etc.) + nombre del empleado asignado.
    // ─────────────────────────────────────────────────────────
    public function detallePedido(int $idPedido): array|null
    {
        return $this->db->table('pedidos p')
            ->select('
                p.id,
                p.titulo,
                p.estado,
                p.prioridad,
                p.fechacreacion,
                p.fechainicio,
                p.fechafin,
                p.fechacompletado,
                p.num_modificaciones,
                p.observacion_revision,
                fp.titulo           AS form_titulo,
                fp.area,
                fp.objetivo_comunicacion,
                fp.descripcion,
                fp.tipo_requerimiento,
                fp.canales_difusion,
                fp.publico_objetivo,
                fp.tiene_materiales,
                fp.formatos_solicitados,
                fp.fecharequerida,
                s.nombre            AS servicio,
                e.nombreempresa     AS empresa,
                u.nombre            AS empleado,
                u.correo            AS correo_empleado
            ')
            ->join('formulario_pedidos fp', 'fp.id = p.idformpedido')
            ->join('servicios s',           's.id = p.idservicio')
            ->join('empresas e',            'e.id = fp.idempresa')
            ->join('usuarios u',            'u.id = p.idempleado', 'left') // LEFT: puede no tener empleado aún
            ->where('p.id', $idPedido)
            ->get()
            ->getRowArray();
    }
}