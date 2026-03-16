<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificacionesModel extends Model
{
    protected $table      = 'notificaciones';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'idpedido',
        'idusuario',
        'asunto',
        'mensaje',
        'tipoalerta',
    ];

    // POST: Crear notificación
    public function crear(int $idPedido, int $idUsuario, string $asunto, string $mensaje, string $tipoAlerta = 'estado'): void
    {
        $this->insert([
            'idpedido'   => $idPedido,
            'idusuario'  => $idUsuario,
            'asunto'     => $asunto,
            'mensaje'    => $mensaje,
            'tipoalerta' => $tipoAlerta,
        ]);
    }

    // GET: Notificaciones de un usuario (cliente)
    public function listarPorUsuario(int $idUsuario): array
    {
        return $this->db->table('notificaciones n')
            ->select('n.id, p.titulo AS pedido, n.asunto, n.mensaje, n.fechaenvio, n.tipoalerta')
            ->join('pedidos p', 'p.id = n.idpedido')
            ->where('n.idusuario', $idUsuario)
            ->orderBy('n.fechaenvio', 'DESC')
            ->get()
            ->getResultArray();
    }
}