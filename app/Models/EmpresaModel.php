<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table      = 'empresas';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = ['idusuario','nombreempresa','ruc','correo','telefono'];

    // GET: Buscar empresa por id del usuario (representante)
    public function buscarPorUsuario(int $idUsuario): array|null
    {
        return $this->db->table('empresas e')
            ->select('e.id, e.nombreempresa, e.ruc, e.correo, e.telefono')
            ->join('usuarios u', 'u.id = e.idusuario')
            ->where('e.idusuario', $idUsuario)
            ->get()
            ->getRowArray();
    }

    // GET: Listar todas las empresas con su representante
    public function listarTodas(): array
    {
        return $this->db->table('empresas e')
            ->select('
                e.id, e.nombreempresa AS empresa, e.ruc,
                e.correo, e.telefono AS contacto_empresa,
                u.nombre || \' \' || u.apellidos AS representante,
                u.telefono AS telefono_representante,
                u.correo AS correo_representante
            ')
            ->join('usuarios u', 'u.id = e.idusuario')
            ->get()
            ->getResultArray();

    }
    // Trae todas las empresas con el nombre correcto de columna
    public function obtenerTodas(): array
    {
        return $this->select('id, nombreempresa, ruc, correo, telefono')
                    ->findAll();
    }
}