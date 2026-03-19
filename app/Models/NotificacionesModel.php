<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificacionesModel extends Model
{
    protected $table      = 'notificaciones';   //Vincula Tabla fisica en BD
    protected $primaryKey = 'id';               //Identifica Id(PK) de la Tabla
    protected $returnType = 'array';            //Definir Datos al Recepcionar
    // Campos que el sistema tiene permiso de escribir
    protected $allowedFields = [
        'idpedido',
        'idusuario',
        'asunto',
        'mensaje',
        'tipoalerta',
    ];

    /**
     * Recupera las alertas vinculadas al usuario (Cliente)
     * @param int $idUsuario
     * @return array
     */
    public function listarPorUsuario(int $idUsuario): array
    {
        return $this->db->table('notificaciones n')
            ->select('n.id, p.titulo AS pedido, n.asunto, n.mensaje, n.fechaenvio, n.tipoalerta')
            ->join('pedidos p', 'p.id = n.idpedido')
            ->where('n.idusuario', $idUsuario)
            ->orderBy('n.fechaenvio', 'DESC')
            ->get()->getResultArray();
    }
}