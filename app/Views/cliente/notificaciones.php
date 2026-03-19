<!--
Notificaciones sobre los Pedidos del Cliente
Muestra Notificaciones sobre los diferentes estados sobre el Cliclo de un Pedido -->

<!-- Heredado -->
<?= $this->extend('plantillas/cliente') ?>
<!-- Plantilla para Inyeccion Datos -->
<?= $this->section('contenido') ?>

<!-- Encabezado -->
<div class="seccion-titulo">MI CUENTA</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="bebas mb-0" style="font-size:1.2rem; letter-spacing:3px; color:#aaa;">CENTRO DE</p>
        <h2 class="bebas mb-0" style="font-size:2.8rem; letter-spacing:2px;">NOTIFICACIONES</h2>
        <p style="font-size:13px; color:#aaa; margin:0;">
            Actualizaciones sobre el estado de tus pedidos
        </p>
    </div>
    <!-- Métricas rápidas -->
    <div class="d-flex gap-4 align-items-center">
        <!-- Cuenta alertas de tipo 'estado' (cambios de proceso) -->
        <div class="text-center">
            <div class="bebas" style="font-size:2.8rem; color:#F5C400; line-height:1;">
                <?= count(array_filter($notificaciones, fn($n) => $n['tipoalerta'] === 'estado')) ?>
            </div>
            <div style="font-size:11px; color:#aaa; letter-spacing:2px; text-transform:uppercase; margin-top:4px;">
                Estado</div>
        </div>
        <div style="width:1px; height:40px; background:#1e1e1e;"></div>
        <!-- Cuenta alertas de tipo 'asignacion' (nuevo responsable) -->
        <div class="text-center">
            <div class="bebas" style="font-size:2.8rem; color:#60a5fa; line-height:1;">
                <?= count(array_filter($notificaciones, fn($n) => $n['tipoalerta'] === 'asignacion')) ?>
            </div>
            <div style="font-size:11px; color:#aaa; letter-spacing:2px; text-transform:uppercase; margin-top:4px;">
                Asignación</div>
        </div>
        <div style="width:1px; height:40px; background:#1e1e1e;"></div>
        <!-- Conteo total del array -->
        <div class="text-center">
            <div class="bebas" style="font-size:2.8rem; color:#f0f0f0; line-height:1;">
                <?= count($notificaciones) ?>
            </div>
            <div style="font-size:11px; color:#aaa; letter-spacing:2px; text-transform:uppercase; margin-top:4px;">Total
            </div>
        </div>
    </div>
</div>

<!-- Lista de notificaciones -->
<div class="seccion-titulo">HISTORIAL</div>

<?php if (empty($notificaciones)): ?>
    <!-- Estado vacío -->
    <div class="card p-5 text-center estado-vacio">
        <i class="bi bi-bell-slash"></i>
        <p>No tienes notificaciones aún</p>
    </div>

<?php else: ?>
    <!-- Listado de Notificaciones -->
    <div class="noti-lista">
        <?php foreach ($notificaciones as $noti): ?>
            <div class="noti-card">
                <!-- Ícono según tipo de alerta -->
                <div class="noti-icono tipo-<?= $noti['tipoalerta'] ?>">
                    <?= render_icono_notificacion($noti['asunto']) ?>
                </div>
                <!-- Contenido -->
                <div class="noti-contenido">
                    <div class="noti-top">
                        <span class="noti-asunto"><?= esc($noti['asunto']) ?></span>
                        <span class="noti-fecha"><?= formato_fecha($noti['fechaenvio']) ?></span>
                    </div>
                    <!-- Cuerpo del Mensaje enviado por el Sistema -->
                    <p class="noti-mensaje"><?= esc($noti['mensaje']) ?></p>
                    <!-- Pedido relacionado -->
                    <div class="noti-pedido">
                        <i class="bi bi-bag-fill"></i>
                        <?= esc($noti['pedido']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>