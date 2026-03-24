<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table      = 'empresas';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['idusuario','nombreempresa','ruc','correo','telefono'];


    /**
     * Busca la empresa asociada a un usuario (representante).
     *
     * @param integer $idUsuario
     * @return array|null
     */
    
    public function buscarPorUsuario(int $idUsuario): array|null
    {
        return $this->db->table('empresas e')
            ->select('e.id, e.nombreempresa, e.ruc, e.correo, e.telefono')
            ->join('usuarios u', 'u.id = e.idusuario')
            ->where('e.idusuario', $idUsuario)
            ->get()
            ->getRowArray();
    }

    /**
     * Lista todas las empresas junto con los datos de su representante.
     *
     * @return array
     */
    
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


    /**
     * Retorna todas las empresas con campos básicos.
     * Trae todas las empresas con el nombre correcto de columna
     * @return array
     */
    public function obtenerTodas(): array
    {
        return $this->select('id, nombreempresa, ruc, correo, telefono')
                    ->findAll();
    }

    /**
     * Retorna todas las empresas con estadísticas de pedidos por estado.
     * Incluye color, inicial e conteos para el dashboard.
     * @return array Empresas con stats: por_aprobar, activos, completados, pendientes, total
     */

    public function obtenerConStats(): array
    {
        $db = \Config\Database::connect();
 
        //Trae todas las empresas reales de la tabla
        $empresas = $this->select('id, nombreempresa, ruc, correo, telefono')->findAll();
 
        foreach ($empresas as &$empresa) {
            $id = $empresa['id'];
           // --- ASIGNACIÓN DE COLORES DIFERENTES ---
            $colores = ['#e07b6b', '#6bbfa0', '#7b9de0', '#d4a85a', '#a87bd4', '#5ab8d4', '#c47aa8'];

             $empresa['color'] = $colores[$empresa['id'] % count($colores)];

 
            // Pedidos de esta empresa via formulario_pedidos → pedidos
            $base = "SELECT COUNT(*) as total FROM pedidos p
                     INNER JOIN formulario_pedidos fp ON fp.id = p.idformpedido
                     WHERE fp.idempresa = {$id}";
 
            //Cuenta pedidos reales por estado
            $empresa['por_aprobar'] = (int) $db->query($base . " AND p.estado = 'por_aprobar'")->getRow()->total;
            $empresa['activos']     = (int) $db->query($base . " AND p.estado = 'en_proceso'")->getRow()->total;
            $empresa['completados'] = (int) $db->query($base . " AND p.estado = 'completado'")->getRow()->total;
            $empresa['pendientes']  = (int) $db->query($base . " AND p.idempleado IS NULL AND p.estado = 'por_aprobar'")->getRow()->total;
            $empresa['total']       = $empresa['activos'] + $empresa['completados'] + $empresa['por_aprobar'];
 
            // Inicial para el ícono
            $empresa['inicial'] = strtoupper(substr($empresa['nombreempresa']?? 'E', 0, 1));
        }
 
        return $empresas;
    }
}