<?= $this->extend('plantillas/cliente') ?>
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
    <!-- Métricas rápidas — aprovecha el espacio horizontal -->
    <div class="d-flex gap-4 align-items-center">
        <div class="text-center">
            <div class="bebas" style="font-size:2.8rem; color:#F5C400; line-height:1;">
                <?= count(array_filter($notificaciones, fn($n) => $n['tipoalerta'] === 'estado')) ?>
            </div>
            <div style="font-size:11px; color:#aaa; letter-spacing:2px; text-transform:uppercase; margin-top:4px;">
                Estado</div>
        </div>
        <div style="width:1px; height:40px; background:#1e1e1e;"></div>
        <div class="text-center">
            <div class="bebas" style="font-size:2.8rem; color:#60a5fa; line-height:1;">
                <?= count(array_filter($notificaciones, fn($n) => $n['tipoalerta'] === 'asignacion')) ?>
            </div>
            <div style="font-size:11px; color:#aaa; letter-spacing:2px; text-transform:uppercase; margin-top:4px;">
                Asignación</div>
        </div>
        <div style="width:1px; height:40px; background:#1e1e1e;"></div>
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
        <p>No tienes notificaciones aún.</p>
    </div>

<?php else: ?>
    <div class="noti-lista">
        <?php foreach ($notificaciones as $noti): ?>
            <div class="noti-card">

                <!-- Ícono según tipo de alerta -->
                <div class="noti-icono tipo-<?= $noti['tipoalerta'] ?>">
                    <?php
                    $asunto = strtolower($noti['asunto']);
                    if (str_contains($asunto, 'proceso') || str_contains($asunto, 'asignado')):
                        ?>
                        <i class="bi bi-arrow-repeat" style="color:#60a5fa"></i>
                    <?php elseif (str_contains($asunto, 'completado') || str_contains($asunto, 'aprobado')): ?>
                        <i class="bi bi-check-circle-fill" style="color:#22c55e"></i>
                    <?php elseif (str_contains($asunto, 'revisión') || str_contains($asunto, 'revision')): ?>
                        <i class="bi bi-eye-fill" style="color:#F5C400"></i>
                    <?php elseif (str_contains($asunto, 'cancelado')): ?>
                        <i class="bi bi-x-circle-fill" style="color:#ef4444"></i>
                    <?php else: ?>
                        <i class="bi bi-bell-fill"></i>
                    <?php endif; ?>
                </div>

                <!-- Contenido -->
                <div class="noti-contenido">
                    <div class="noti-top">
                        <span class="noti-asunto"><?= esc($noti['asunto']) ?></span>
                        <!--Recorta el timestamp a solo la fecha -->
                        <span class="noti-fecha"><?= substr($noti['fechaenvio'], 0, 10) ?></span>
                    </div>
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