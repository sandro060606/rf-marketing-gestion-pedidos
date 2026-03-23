<?= $this->extend('plantillas/principal') ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('recursos/styles/paginas/kanban.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<?php
$areas   = (new \App\Models\AreaModel())->findAll();
$inicial = mb_strtoupper(mb_substr($empresa['nombreempresa'], 0, 1));
$vistaActiva = isset($_GET['vista']) ? $_GET['vista'] : 'kanban';
?>

<!-- CABECERA EMPRESA -->
<div class="kb-head">
    <div class="kb-head-left">
        <div class="kb-emp-avatar" style="background:<?= $empresa['color'] ?>; color:#000;">
    <?= $inicial ?>
</div>
        <div>
            <div class="kb-emp-nombre"><?= esc(strtoupper($empresa['nombreempresa'])) ?></div>
            <div class="kb-emp-meta">
                RUC <?= esc($empresa['ruc'] ?? '—') ?>
                <?php if (!empty($empresa['correo'])) : ?>
                    · <?= esc($empresa['correo']) ?>
                <?php endif ?>
                <?php if (!empty($empresa['telefono'])) : ?>
                    · <?= esc($empresa['telefono']) ?>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="kb-head-stats">
        <div class="kb-stat"><span class="amarillo"><?= $stats['activos'] ?? 0 ?></span><small>ACTIVOS</small></div>
        <div class="kb-stat"><span class="morado"><?= $stats['por_aprobar'] ?? 0 ?></span><small>POR APROBAR</small></div>
        <div class="kb-stat"><span class="verde"><?= $stats['completados'] ?? 0 ?></span><small>COMPLETADOS</small></div>
    </div>
</div>

<!-- TABS -->
<div class="kb-tabs">
   <button class="kb-tab kb-tab-kanban    <?= $vistaActiva === 'kanban'    ? 'activo' : '' ?>" id="btn-kanban"    onclick="switchVista('kanban')">⊞ Kanban</button>
<button class="kb-tab kb-tab-historial <?= $vistaActiva === 'historial' ? 'activo' : '' ?>" id="btn-historial" onclick="switchVista('historial')">☰ Historial (<?= count($historial) ?>)</button>
<button class="kb-tab kb-tab-cancel    <?= $vistaActiva === 'cancelados'? 'activo' : '' ?>" id="btn-cancelados" onclick="switchVista('cancelados')">✕ Cancelados (<?= count($cancelados) ?>)</button>
</div>

<!-- ÁREAS (solo en kanban) -->
<div class="kb-areas" id="tabs-areas" <?= $vistaActiva !== 'kanban' ? 'style="display:none"' : '' ?>>
    <?php foreach ($areas as $a) : ?>
        <a href="<?= site_url('admin/kanban/'.$idEmpresa.'/'.$a['id']) ?>"
           class="kb-area-tab <?= $a['id'] == $area['id'] ? 'activo' : '' ?>">
            <?= esc($a['nombre']) ?>
        </a>
    <?php endforeach ?>
</div>

<!-- VISTA KANBAN -->
<div id="vista-kanban" <?= $vistaActiva !== 'kanban' ? 'style="display:none"' : '' ?>>
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
                                <?= $p['empleado'] ? mb_strtoupper(mb_substr($p['empleado'],0,1).mb_substr($p['empleado_ap'],0,1)) : '?' ?>
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
</div>

<!-- VISTA HISTORIAL -->
<div id="vista-historial" <?= $vistaActiva !== 'historial' ? 'style="display:none"' : '' ?>>
    <?= view('administrador/pedidos/_tabla_historial', ['filas' => $historial, 'tipo' => 'historial']) ?>
</div>

<!-- VISTA CANCELADOS -->
<div id="vista-cancelados" <?= $vistaActiva !== 'cancelados' ? 'style="display:none"' : '' ?>>
    <?= view('administrador/pedidos/_tabla_historial', ['filas' => $cancelados, 'tipo' => 'cancelados']) ?>
</div>

<script>
function switchVista(vista) {
    ['kanban','historial','cancelados'].forEach(v => {
        document.getElementById('vista-' + v).style.display = v === vista ? 'block' : 'none';
    });
    document.getElementById('tabs-areas').style.display = vista === 'kanban' ? 'flex' : 'none';
    document.querySelectorAll('.kb-tab').forEach(b => b.classList.remove('activo'));
    document.getElementById('btn-' + vista).classList.add('activo');
}
</script>

<?= $this->endSection() ?>