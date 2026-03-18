<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table      = 'empresas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['idusuario','nombreempresa','ruc','correo','telefono'];

    // Trae todas las empresas con el nombre correcto de columna
    public function obtenerTodas(): array
    {
        return $this->select('id, nombreempresa, ruc, correo, telefono')
                    ->findAll();
    }
// Para el dashboard: empresas con conteo de pedidos por estado
    public function obtenerConStats(): array
    {
        $db = \Config\Database::connect();
 
        $empresas = $this->select('id, nombreempresa, ruc')->findAll();
 
        foreach ($empresas as &$empresa) {
            $id = $empresa['id'];
           // --- ASIGNACIÓN DE COLORES DIFERENTES ---
            $colores = ['#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#FF00FF', '#00FFFF', '#FFA500'];

             $empresa['color'] = $colores[($empresa['id'] * 3) % count($colores)];

 
            // Pedidos de esta empresa via formulario_pedidos → pedidos
            $base = "SELECT COUNT(*) as total FROM pedidos p
                     INNER JOIN formulario_pedidos fp ON fp.id = p.idformpedido
                     WHERE fp.idempresa = {$id}";
 
            $empresa['por_aprobar'] = (int) $db->query($base . " AND p.estado = 'por_aprobar'")->getRow()->total;
            $empresa['activos']     = (int) $db->query($base . " AND p.estado = 'en_proceso'")->getRow()->total;
            $empresa['completados'] = (int) $db->query($base . " AND p.estado = 'completado'")->getRow()->total;
            $empresa['pendientes']  = (int) $db->query($base . " AND p.idempleado IS NULL AND p.estado = 'por_aprobar'")->getRow()->total;
            $empresa['total']       = $empresa['activos'] + $empresa['completados'] + $empresa['por_aprobar'];
 
            // Inicial para el ícono
            $empresa['inicial'] = strtoupper(substr($empresa['nombreempresa'], 0, 1));
        }
 
        return $empresas;
    }
}