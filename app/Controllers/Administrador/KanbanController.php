<?php

namespace App\Controllers\Administrador;

use App\Controllers\BaseController;
use App\Models\AreaModel;
use App\Models\EmpresaModel;

class KanbanController extends BaseController
{
    public function index(int $idEmpresa, int $idArea): string
    {
        $db = \Config\Database::connect();

        // Busco el área por su ID (ej: id=1 → "Diseño Grafico")
        $area = (new AreaModel())->find($idArea);
        if (!$area) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Armo el query base uniendo las tablas que necesito
        $builder = $db->table('pedidos p')
            ->select('
                p.id, p.titulo, p.estado, p.prioridad,
                p.fechacreacion, p.fechafin,
                s.nombre        AS servicio,
                u.nombre        AS empleado,
                u.apellidos     AS empleado_ap,
                e.nombreempresa AS empresa,
                fp.area         AS area_solicitante
            ')
            ->join('formulario_pedidos fp', 'fp.id = p.idformpedido') // para saber de qué empresa es el pedido
            ->join('servicios s',           's.id = p.idservicio')    // para obtener el nombre del servicio
            ->join('empresas e',            'e.id = fp.idempresa')    // para mostrar el nombre de la empresa
            ->join('usuarios u',            'u.id = p.idempleado', 'left') // LEFT porque puede no tener empleado aún

            // Solo traigo pedidos de la empresa que seleccioné
            ->where('fp.idempresa', $idEmpresa);

        // Como fp.area tiene texto inconsistente ("diseño", "Disecion Academica", etc.)
        // en lugar de compararlo directamente, busco por la primera palabra del área
        // Ej: "Diseño Grafico" → busco servicios que contengan "Diseño"
        $nombreArea  = trim($area['nombre']);
        $palabraClave = explode(' ', $nombreArea)[0];

        $builder->groupStart()
                    ->like('s.nombre', $palabraClave, 'both', null, true)
                    ->orLike('s.nombre', $nombreArea, 'both', null, true)
                ->groupEnd();

        // Excluyo cancelados y ordeno del más reciente al más antiguo
        $pedidos = $builder->whereNotIn('p.estado', ['cancelado'])
                           ->orderBy('p.fechacreacion', 'DESC')
                           ->get()->getResultArray();

        // Defino las 4 columnas del kanban vacías
        $columnas = [
            'por_aprobar' => ['label' => 'Por Aprobar', 'items' => []],
            'activo'      => ['label' => 'Activo',      'items' => []],
            'revision'    => ['label' => 'Revisión',    'items' => []],
            'completado'  => ['label' => 'Completado',  'items' => []],
        ];

        // Meto cada pedido en la columna que le corresponde según su estado
        foreach ($pedidos as $p) {
            $st = strtolower(trim($p['estado'] ?? ''));

            // Normalizo variantes por si hay diferencias de texto en la BD
            if (in_array($st, ['por aprobar', 'pendiente', 'nuevo'])) $st = 'por_aprobar';
            if (in_array($st, ['activo', 'en proceso', 'ejecucion']))  $st = 'activo';
            if (in_array($st, ['revision', 'revisión']))               $st = 'revision';
            if (in_array($st, ['completado', 'finalizado', 'terminado'])) $st = 'completado';

            if (isset($columnas[$st])) {
                $columnas[$st]['items'][] = $p;
            } else {
                // Si el estado no coincide con ninguna columna, lo mando a "Por Aprobar"
                // para que no se pierda ningún pedido visualmente
                $columnas['por_aprobar']['items'][] = $p;
            }
        }

        return view('administrador/pedidos/kanban', [
            'area'         => $area,
            'columnas'     => $columnas,
            'paginaActual' => 'kanban',
            'empresas'     => (new EmpresaModel())->findAll(), // para la barra lateral
            'idEmpresa' => $idEmpresa,
        ]);
    }
}
