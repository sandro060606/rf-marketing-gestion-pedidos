<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'idformpedido',
        'idadmin',
        'idempleado',
        'idservicio',
        'titulo',
        'prioridad',
        'estado',
        'num_modificaciones',
        'observacion_revision',
        'fechainicio',
        'horainicio',
        'fechafin',
        'horafin',
        'fechacompletado',
        'cancelacionmotivo',
        'fechacancelacion'
    ];

    /**
     * Realiza una consulta para obtener información sobre los Pedidos de los Clientes
     * @param int $idUsuario
     * @return array
     */
    public function listarPorCliente(int $idUsuario): array
    {
        return $this->db->table('pedidos p')
            ->select('
                p.id,p.titulo,p.estado,p.prioridad,p.fechacreacion,
                p.fechainicio,p.fechafin,p.num_modificaciones,
                s.nombre  AS servicio,
                e.nombreempresa AS empresa
            ')
            ->join('servicios s', 's.id = p.idservicio')
            ->join('formulario_pedidos fp', 'fp.id = p.idformpedido')
            ->join('empresas e', 'e.id = fp.idempresa')
            ->where('e.idusuario', $idUsuario) // Solo pedidos de su empresa (Filtro)
            ->orderBy('p.fechacreacion', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene toda la información detallada de un pedido 
     * (datos del formulario, servicio, empresa y empleado asignado)
     * @param int $idPedido
     * @return array|null Retorna los datos del pedido o null si no existe
     */
    public function detallePedido(int $idPedido): array|null
    {
        return $this->db->table('pedidos p')
            ->select('
                p.id,p.titulo,p.estado,p.prioridad,p.fechacreacion,p.fechainicio,
                p.fechafin,p.fechacompletado,p.num_modificaciones,p.observacion_revision,
                fp.titulo           AS form_titulo,
                fp.area,fp.objetivo_comunicacion,fp.descripcion,fp.tipo_requerimiento,
                fp.canales_difusion,fp.publico_objetivo,fp.tiene_materiales,fp.formatos_solicitados,
                fp.fecharequerida,
                s.nombre            AS servicio,
                e.nombreempresa     AS empresa,
                u.nombre            AS empleado,
                u.correo            AS correo_empleado
            ')
            ->join('formulario_pedidos fp', 'fp.id = p.idformpedido')
            ->join('servicios s', 's.id = p.idservicio')
            ->join('empresas e', 'e.id = fp.idempresa')
            ->join('usuarios u', 'u.id = p.idempleado', 'left') // LEFT: puede no tener empleado aún
            ->where('p.id', $idPedido)
            ->get()->getRowArray();
    }

    
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