<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    // Configuración del modelo
    protected $table = 'usuarios';      // Tabla principal
    protected $primaryKey = 'id';       // Clave primaria
    protected $returnType = 'array';    // Retorna arrays, no objetos

    /**
     * Busca un usuario activo por su nombre de usuario.
     * Incluye el nombre del área mediante JOIN con la tabla areas.
     * @param string $usuario Nombre de usuario a buscar
     * @return array|null Datos del usuario o null si no existe
     */

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

    /**
     * Retorna todos los usuarios con su área o empresa asignada.
     * Usa COALESCE para mostrar el área si es empleado o la empresa si es cliente.
     * @return array Lista de usuarios con área o empresa incluida
     */
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
            COALESCE(a.nombre, e.nombreempresa) AS area
        ')
        ->join('areas a', 'a.id = u.idarea', 'left')
        ->join('empresas e', 'e.idusuario = u.id', 'left')
        ->orderBy('u.nombre', 'ASC')
        ->get()
        ->getResultArray();
}
}