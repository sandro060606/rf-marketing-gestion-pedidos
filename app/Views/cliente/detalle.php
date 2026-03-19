<?= $this->extend('plantillas/cliente') ?>
<?= $this->section('contenido') ?>

<!-- Encabezado  -->
<div class="seccion-titulo">MIS PEDIDOS</div>

<div class="d-flex align-items-center gap-3 mb-4">
    <!-- Botón volver -->
    <a href="<?= base_url('cliente/mis-pedidos') ?>" class="btn-volver">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <p style="font-size:10px; color:#555; margin:0; letter-spacing:2px; text-transform:uppercase;">
            PEDIDO #<?= $pedido['id'] ?>
        </p>
        <h2 class="bebas mb-0" style="font-size:1.8rem; letter-spacing:2px;">
            <?= $pedido['titulo'] ? esc($pedido['titulo']) : 'Pendiente de revisión' ?>
        </h2>
    </div>
    <!-- Badge estado -->
    <?= badge_estado($pedido['estado']) ?>
</div>

<!-- Grid principal -->
<div class="detalle-grid">

    <!--  Columna izquierda — Info del pedido  -->
    <div class="detalle-col-main">

        <!-- Datos generales -->
        <div class="seccion-titulo">INFORMACIÓN GENERAL</div>
        <div class="card mb-3" style="padding:0; overflow:hidden;">
            <div class="info-fila">
                <span class="info-label">Servicio</span>
                <span class="info-valor">
                    <span class="area-btn"><?= esc($pedido['servicio']) ?></span>
                </span>
            </div>
            <div class="info-fila">
                <span class="info-label">Empresa</span>
                <span class="info-valor"><?= esc($pedido['empresa']) ?></span>
            </div>
            <div class="info-fila">
                <span class="info-label">Área</span>
                <span class="info-valor"><?= esc($pedido['area']) ?></span>
            </div>
            <div class="info-fila">
                <span class="info-label">Tipo</span>
                <span class="info-valor"><?= esc($pedido['tipo_requerimiento']) ?></span>
            </div>
            <div class="info-fila">
                <span class="info-label">Fecha requerida</span>
                <span class="info-valor"><?= substr($pedido['fecharequerida'], 0, 10) ?></span>
            </div>
            <div class="info-fila">
                <span class="info-label">Fecha creación</span>
                <span class="info-valor"><?= substr($pedido['fechacreacion'], 0, 10) ?></span>
            </div>
            <?php if ($pedido['fechacompletado']): ?>
                <div class="info-fila">
                    <span class="info-label">Fecha completado</span>
                    <span class="info-valor" style="color:#22c55e;">
                        <?= substr($pedido['fechacompletado'], 0, 10) ?>
                    </span>
                </div>
            <?php endif; ?>
            <?php if ($pedido['prioridad']): ?>
                <div class="info-fila">
                    <span class="info-label">Prioridad</span>
                    <span class="info-valor">
                        <span class="badge-prio prio-<?= $pedido['prioridad'] ?>">
                            <?= ucfirst($pedido['prioridad']) ?>
                        </span>
                    </span>
                </div>
            <?php endif; ?>
            <?php if ($pedido['num_modificaciones'] > 0): ?>
                <div class="info-fila">
                    <span class="info-label">Modificaciones</span>
                    <span class="info-valor" style="color:#f97316;">
                        <?= $pedido['num_modificaciones'] ?> vez(ces)
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Objetivo de comunicación -->
        <div class="seccion-titulo">OBJETIVO DE COMUNICACIÓN</div>
        <div class="card p-3 mb-3">
            <p style="font-size:13px; color:#aaa; line-height:1.6; margin:0;">
                <?= nl2br(esc($pedido['objetivo_comunicacion'])) ?>
            </p>
        </div>

        <!-- Descripción -->
        <div class="seccion-titulo">DESCRIPCIÓN DETALLADA</div>
        <div class="card p-3 mb-3">
            <p style="font-size:13px; color:#aaa; line-height:1.6; margin:0;">
                <?= nl2br(esc($pedido['descripcion'])) ?>
            </p>
        </div>

        <!-- Observación si fue rechazado -->
        <?php if ($pedido['observacion_revision']): ?>
            <div class="seccion-titulo">OBSERVACIÓN DEL REVISOR</div>
            <div class="card p-3 mb-3" style="border-color:rgba(239,68,68,0.3);">
                <p style="font-size:13px; color:#ef4444; line-height:1.6; margin:0;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= nl2br(esc($pedido['observacion_revision'])) ?>
                </p>
            </div>
        <?php endif; ?>

    </div>

    <!--  Columna derecha — Detalles adicionales -->
    <div class="detalle-col-side">

        <!-- Empleado asignado -->
        <div class="seccion-titulo">RESPONSABLE</div>
        <div class="card p-3 mb-3">
            <?php if ($pedido['empleado']): ?>
                <div class="d-flex align-items-center gap-3">
                    <div class="user-avatar" style="width:36px;height:36px;font-size:0.85rem;flex-shrink:0;">
                        <?= strtoupper(substr($pedido['empleado'], 0, 1)) ?>
                    </div>
                    <div>
                        <p style="font-size:13px; font-weight:600; margin:0; color:#f0f0f0;">
                            <?= esc($pedido['empleado']) ?>
                        </p>
                        <p style="font-size:11px; color:#555; margin:0;">
                            <?= esc($pedido['correo_empleado']) ?>
                        </p>
                    </div>
                </div>
            <?php else: ?>
                <p style="font-size:12px; color:#555; margin:0; font-style:italic;">
                    Aún no asignado — en revisión por el administrador.
                </p>
            <?php endif; ?>
        </div>

        <!-- Canales de difusión -->
        <?php
        // canales_difusion viene como JSON string de la BD
        // json_decode lo convierte a array PHP
        $canales = json_decode($pedido['canales_difusion'] ?? '[]', true);
        ?>
        <?php if (!empty($canales)): ?>
            <div class="seccion-titulo">CANALES DE DIFUSIÓN</div>
            <div class="card p-3 mb-3">
                <div class="tags-lista">
                    <?php foreach ($canales as $canal): ?>
                        <span class="tag-item"><?= esc($canal) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Público objetivo -->
        <?php if ($pedido['publico_objetivo']): ?>
            <div class="seccion-titulo">PÚBLICO OBJETIVO</div>
            <div class="card p-3 mb-3">
                <p style="font-size:12px; color:#aaa; margin:0; line-height:1.5;">
                    <?= esc($pedido['publico_objetivo']) ?>
                </p>
            </div>
        <?php endif; ?>

        <!-- Formatos solicitados -->
        <?php
        $formatos = json_decode($pedido['formatos_solicitados'] ?? '[]', true);
        ?>
        <?php if (!empty($formatos)): ?>
            <div class="seccion-titulo">FORMATOS SOLICITADOS</div>
            <div class="card p-3 mb-3">
                <div class="tags-lista">
                    <?php foreach ($formatos as $formato): ?>
                        <span class="tag-item"><?= esc($formato) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?= $this->include('cliente/parciales/archivos') ?>

    </div>
</div>

<?= $this->endSection() ?>