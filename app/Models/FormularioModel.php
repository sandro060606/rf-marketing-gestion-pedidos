<?php

namespace App\Models;

use CodeIgniter\Model;

class FormularioModel extends Model
{
    protected $table = 'formulario_pedidos';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    // Campos con permiso de escritura
    protected $allowedFields = [
        'idempresa',
        'idservicio',
        'titulo',
        'area',
        'objetivo_comunicacion',
        'descripcion',
        'tipo_requerimiento',
        'canales_difusion',
        'publico_objetivo',
        'tiene_materiales',
        'formatos_solicitados',
        'formato_otros',
        'fecharequerida',
        'prioridad',
    ];

    /**
     * Lista los formularios enviados por una empresa
     * @param int $idEmpresa
     * @return array
     */
    public function listarPorEmpresa(int $idEmpresa): array
    {
        return $this->db->table('formulario_pedidos fp')
            ->select('
                fp.id, fp.titulo, fp.area, fp.tipo_requerimiento,
                fp.prioridad, fp.fecharequerida, fp.fechacreacion,
                s.nombre AS servicio
            ')
            ->join('servicios s', 's.id = fp.idservicio')
            ->where('fp.idempresa', $idEmpresa)
            ->orderBy('fp.fechacreacion', 'DESC')
            ->get()->getResultArray();
    }
}