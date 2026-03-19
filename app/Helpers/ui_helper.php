<?php
// Funciones reutilizables para la UI
function badge_estado(string $estado): string {
    $texto = ucwords(str_replace('_', ' ', $estado));
    return "<span class=\"badge-estado estado-{$estado}\">{$texto}</span>";
}

function badge_prio(?string $prioridad): string {
    if (!$prioridad) return '<span style="color:#555;">—</span>';
    return "<span class=\"badge-prio prio-{$prioridad}\">" . ucfirst($prioridad) . "</span>";
}

function formato_fecha(?string $fecha): string {
    return $fecha ? substr($fecha, 0, 10) : '—';
}