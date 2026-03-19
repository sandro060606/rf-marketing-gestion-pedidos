<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    // Configuración del modelo
    protected $table = 'usuarios';      // Tabla principal
    protected $primaryKey = 'id';       // Clave primaria
    protected $returnType = 'array';    // Retorna arrays, no objetos

    // LOGIN: Busca usuario activo por nombre de usuario
    // Retorna: array con todos los datos | null si no existe
    public function buscarPorUsuario(string $usuario): array|null
    {
        return $this->db->table('usuarios u')
            ->select('
                u.id,
                u.nombre,
                u.apellidos,
                u.correo,
                u.usuario,
                u.clave,
                u.rol,
                u.idarea,
                u.esresponsable,
                u.estado,
                a.nombre AS area
            ')
            ->join('areas a', 'a.id = u.idarea', 'left') // LEFT porque admin no tiene área
            ->where('u.usuario', $usuario)               // Filtra por nombre de usuario
            ->where('u.estado', true)                    // Solo usuarios activos (estado = true)
            ->get()
            ->getRowArray();                             // Una fila o null
    }
    public function obtenerTodosConArea(): array
{
    return $this->db->table('usuarios u')
        ->select('
            u.id,
            u.nombre,
            u.apellidos,
            u.usuario,
            u.rol,
            u.estado,
            u.idarea,
            a.nombre AS area
        ')
        ->join('areas a', 'a.id = u.idarea', 'left')
        ->orderBy('u.nombre', 'ASC')
        ->get()
        ->getResultArray();
}
}