<?php
/**
 * Genera un Badge (etiqueta de color) según el estado del pedido
 * @param string $estado El código del estado (ej: 'en_proceso')
 * @return string
 */
function badge_estado(string $estado): string
{
    //Limpia el Texto del Estado (Legible)
    $texto = ucwords(str_replace('_', ' ', $estado));
    //Devuelve el Estado (UI y CSS)
    return "<span class=\"badge-estado estado-{$estado}\">{$texto}</span>";
}

/**
 * Genera un Badge de prioridad con colores distintos
 * @param mixed $prioridad La prioridad del pedido ('alta', 'media', 'baja')
 * @return string
 */
function badge_prioridad(?string $prioridad): string
{
    //Si no hay prioridad, devuelve un guión
    if (!$prioridad)
        return '<span style="color:#555;">—</span>';
    //Retorna el texto de la prioridad con la primera letra en mayúscula
    return "<span class=\"badge-prio prio-{$prioridad}\">" . ucfirst($prioridad) . "</span>";
}

/**
 * Limpia y recorta la fecha, muestra solo el día
 * @param mixed $fecha Fecha completa de la DB (YYYY-MM-DD HH:MM:SS)
 * @return string Solo la fecha (YYYY-MM-DD)
 */
function formato_fecha(?string $fecha): string
{
    // substr toma los primeros 10 caracteres de la cadena
    return $fecha ? substr($fecha, 0, 10) : '—';
}

/**
 * Genera el bloque visual del responsable asignado (Avatar + Info)
 * @param string|null $nombre Nombre del empleado
 * @param string|null $correo Correo del empleado
 * @return string HTML estructurado del responsable
 */
function render_responsable(?string $nombre, ?string $correo): string
{
    // Validar Responsable
    if (!$nombre) {
        return '<p style="font-size:12px; color:#555; margin:0; font-style:italic;">
                    Aún no asignado — en revisión por el administrador.
                </p>';
    }

    // Extraer la inicial y convertir a mayúscula para el avatar
    $inicial = strtoupper(substr($nombre, 0, 1));
    $nombreEsc = esc($nombre);
    $correoEsc = esc($correo ?? 'Sin correo');

    // Retornar el HTML limpio
    return "
        <div class=\"d-flex align-items-center gap-3\">
            <div class=\"user-avatar\" style=\"width:36px;height:36px;font-size:0.85rem;flex-shrink:0;\">
                {$inicial}
            </div>
            <div>
                <p style=\"font-size:13px; font-weight:600; margin:0; color:#f0f0f0;\">{$nombreEsc}</p>
                <p style=\"font-size:11px; color:#555; margin:0;\">{$correoEsc}</p>
            </div>
        </div>";
}

/**
 * Determina el icono de Bootstrap y su color según el asunto de la notificación
 * @param string $asunto El título de la notificación
 * @return string HTML del icono <i>
 */
function render_icono_notificacion(string $asunto): string
{
    $asunto = strtolower($asunto);
    // Definición de iconos y colores por palabras clave
    if (str_contains($asunto, 'proceso') || str_contains($asunto, 'asignado')) {
        return '<i class="bi bi-arrow-repeat" style="color:#60a5fa"></i>';
    }
    if (str_contains($asunto, 'completado') || str_contains($asunto, 'aprobado')) {
        return '<i class="bi bi-check-circle-fill" style="color:#22c55e"></i>';
    }
    if (str_contains($asunto, 'revisión') || str_contains($asunto, 'revision')) {
        return '<i class="bi bi-eye-fill" style="color:#F5C400"></i>';
    }
    if (str_contains($asunto, 'cancelado')) {
        return '<i class="bi bi-x-circle-fill" style="color:#ef4444"></i>';
    }
    // Icono por defecto si no coincide ninguna palabra
    return '<i class="bi bi-bell-fill"></i>';
}

//Cubierto con Un If, por el Foreach (N° Veces)
if (!function_exists('obtener_estilo_servicio')) {
    /**
     * Obtiene la configuración visual de un servicio basado en su nombre.
     * Útil para mantener la consistencia visual en toda la plataforma.
     */
    function obtener_estilo_servicio(string $nombreServicio): array
    {
        $nombre = strtolower($nombreServicio);

        // Configuración por defecto (Servicio General)
        $config = [
            'icono' => 'bi-briefcase-fill',
            'color' => '#c084fc',
            'bg' => 'rgba(192,132,252,0.08)',
            'border' => 'rgba(192,132,252,0.2)',
            'tag' => 'SERVICIO'
        ];

        // Lógica para Diseño
        if (str_contains($nombre, 'diseño') || str_contains($nombre, 'grafico') || str_contains($nombre, 'gráfico')) {
            $config['icono'] = 'bi-palette-fill';
            $config['color'] = '#F5C400';
            $config['bg'] = 'rgba(245,196,0,0.08)';
            $config['border'] = 'rgba(245,196,0,0.2)';
            $config['tag'] = 'DISEÑO GRÁFICO';
        }
        // Lógica para Audiovisual
        elseif (str_contains($nombre, 'audio') || str_contains($nombre, 'video') || str_contains($nombre, 'visual')) {
            $config['icono'] = 'bi-camera-video-fill';
            $config['color'] = '#60a5fa';
            $config['bg'] = 'rgba(96,165,250,0.08)';
            $config['border'] = 'rgba(96,165,250,0.2)';
            $config['tag'] = 'AUDIOVISUAL';
        }

        return $config;
    }
}