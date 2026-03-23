<?= $this->extend('plantillas/principal') ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('recursos/styles/paginas/kanban.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<div class="kb-header">
    <button class="kb-back" onclick="history.back()">← Volver</button>
    <p class="seccion-titulo mb-0"><?= esc($area['nombre']) ?></p>
</div>

<div class="kb-board">
    <?php foreach ($columnas as $estado => $col) : ?>
    <div class="kb-col">
        <div class="kb-col-head">
            <span class="kb-col-title"><?= $col['label'] ?></span>
            <span class="kb-col-count kb-count-<?= $estado ?>"><?= count($col['items']) ?></span>
        </div>
        <div class="kb-col-body">
            <?php if (empty($col['items'])) : ?>
                <div class="kb-empty">Sin pedidos</div>
            <?php else : ?>
                <?php foreach ($col['items'] as $p) : ?>
                <div class="kb-card" onclick="window.location.href='<?= site_url('admin/pedidos/'.$p['id']) ?>'">
                    <div class="kb-card-service"><?= esc($p['servicio']) ?>
                        <?php if ($p['prioridad'] === 'alta') : ?>
                            <span class="kb-prioridad">▲ ALTA</span>
                        <?php endif ?>
                    </div>
                    <div class="kb-card-title"><?= esc($p['titulo'] ?? 'Sin título') ?></div>
                    <?php if ($p['estado'] === 'activo' && !$p['empleado']) : ?>
                        <span class="kb-pill kb-pendiente">Pendiente</span>
                    <?php endif ?>
                    <div class="kb-card-footer">
                        <span class="kb-avatar">
                            <?php if ($p['empleado']) : ?>
                                <?= mb_strtoupper(mb_substr($p['empleado'], 0, 1) . mb_substr($p['empleado_ap'], 0, 1)) ?>
                            <?php else : ?>
                                ?
                            <?php endif ?>
                        </span>
                        <span class="kb-card-name"><?= $p['empleado'] ? esc($p['empleado'].' '.$p['empleado_ap']) : 'Sin asignar' ?></span>
                        <?php if ($p['fechafin']) : ?>
                            <span class="kb-fecha"><?= date('d M Y', strtotime($p['fechafin'])) ?></span>
                        <?php endif ?>
                    </div>
                    <button class="kb-btn-ver">Ver / Editar →</button>
                </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
    <?php endforeach ?>
</div>

<?= $this->endSection() ?>