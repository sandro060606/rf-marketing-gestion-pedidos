<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    // Tabla que usa este modelo
    protected $table      = 'usuarios';

    // Clave primaria de la tabla
    protected $primaryKey = 'id';

    // Los resultados se devuelven como arreglo
    protected $returnType = 'array';

    // Busca un usuario por su nombre de usuario
    // Solo devuelve el usuario si está activo (estado = true)
    // Devuelve un solo registro o null si no existe
    public function buscarPorUsuario($usuario)
    {
        return $this->where('usuario', $usuario)
                    ->where('estado', true)
                    ->first();
    }
}