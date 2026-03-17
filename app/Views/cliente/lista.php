<?php
// Hereda: plantillas/cliente.php
// Recibe: $pedidos (array), $titulo (string)
?>
<?= $this->extend('plantillas/cliente') ?>
<?= $this->section('contenido') ?>

<!-- Encabezado -->
<div class="seccion-titulo">MIS PEDIDOS</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="bebas mb-0" style="font-size:2rem; letter-spacing:2px;">
            <?= session()->get('nombre') ?>
        </h2>
        <p class="text-muted small mb-0" style="font-size:11px;">
            <?= session()->get('area') ?? 'Cliente' ?> — Historial de requerimientos
        </p>
    </div>
    <a href="<?= base_url('cliente/nuevo-pedido') ?>" class="btn-rf">
        <i class="bi bi-plus-lg"></i> Nuevo Pedido
    </a>
</div>

<!-- Métricas resumen -->
<div class="seccion-titulo">RESUMEN</div>
<div class="row g-2 mb-4">
    <!-- Por Aprobar -->
    <div class="col-6 col-md-3">
        <div class="card p-3">
            <div class="met-label">Por Aprobar</div>
            <div class="met-num amarillo">
                <?= count(array_filter($pedidos, fn($p) => $p['estado'] === 'por_aprobar')) ?>
            </div>
            <div class="met-sub">Pendientes de revisión</div>
        </div>
    </div>
    <!-- En Proceso -->
    <div class="col-6 col-md-3">
        <div class="card p-3">
            <div class="met-label">En Proceso</div>
            <div class="met-num azul">
                <?= count(array_filter($pedidos, fn($p) => $p['estado'] === 'en_proceso')) ?>
            </div>
            <div class="met-sub">En curso</div>
        </div>
    </div>
    <!-- Completados -->
    <div class="col-6 col-md-3">
        <div class="card p-3">
            <div class="met-label">Completados</div>
            <div class="met-num verde">
                <?= count(array_filter($pedidos, fn($p) => $p['estado'] === 'completado')) ?>
            </div>
            <div class="met-sub">Total histórico</div>
        </div>
    </div>
    <!-- Total -->
    <div class="col-6 col-md-3">
        <div class="card p-3">
            <div class="met-label">Total</div>
            <div class="met-num" style="color:#f0f0f0"><?= count($pedidos) ?></div>
            <div class="met-sub">Todos los pedidos</div>
        </div>
    </div>

</div>

<!-- Tabla de pedidos -->
<div class="seccion-titulo">TODOS LOS PEDIDOS</div>

<div class="card" style="overflow:hidden;">
    <!-- Header tabla con buscador -->
    <div class="tabla-header">
        <div class="buscador-wrap">
            <i class="bi bi-search" style="color:#555; font-size:12px;"></i>
            <input type="text" id="buscador" placeholder="Buscar pedido..." class="input-buscar">
        </div>
    </div>

    <div class="table-responsive">
        <table class="tabla-rf" id="tablaPedidos">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Servicio</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pedidos)): ?>
                    <tr>
                        <td colspan="7" class="estado-vacio">
                            <i class="bi bi-inbox"></i>
                            <p>Aún no tienes pedidos registrados.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td style="color:#555; font-size:11px;">#<?= $pedido['id'] ?></td>

                            <td>
                                    <?php if ($pedido['titulo']): ?>
                                    <span style="font-weight:600; font-size:13px;">
                                            <?= esc($pedido['titulo']) ?>
                                    </span>
                                    <?php else: ?>
                                    <!-- El admin aún no procesó este pedido -->
                                    <span style="color:#555; font-style:italic; font-size:12px;">
                                        Pendiente de revisión
                                    </span>
                                    <?php endif; ?>
                            </td>

                            <td>
                                <span class="area-btn" style="cursor:default;">
                                        <?= esc($pedido['servicio']) ?>
                                </span>
                            </td>

                            <!-- str_replace convierte 'por_aprobar' → 'Por Aprobar' -->
                            <td>
                                <span class="badge-estado estado-<?= $pedido['estado'] ?>">
                                        <?= ucwords(str_replace('_', ' ', $pedido['estado'])) ?>
                                </span>
                            </td>

                            <!-- null si el admin aún no asignó prioridad -->
                            <td>
                                    <?php if ($pedido['prioridad']): ?>
                                    <span class="badge-prio prio-<?= $pedido['prioridad'] ?>">
                                            <?= ucfirst($pedido['prioridad']) ?>
                                    </span>
                                    <?php else: ?>
                                    <span style="color:#555;">—</span>
                                    <?php endif; ?>
                            </td>

                            <!-- substr recorta timestamp → solo fecha -->
                            <td style="color:#555; font-size:11px;">
                                    <?= substr($pedido['fechacreacion'], 0, 10) ?>
                            </td>

                            <td>
                                <a href="<?= base_url('cliente/mis-pedidos/' . $pedido['id']) ?>" class="btn-ver"
                                    title="Ver detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Buscador en tiempo real sin librerías externas -->
<script>
    document.getElementById('buscador').addEventListener('keyup', function () {
        const termino = this.value.toLowerCase();
        document.querySelectorAll('#tablaPedidos tbody tr').forEach(function (fila) {
            fila.style.display = fila.textContent.toLowerCase().includes(termino) ? '' : 'none';
        });
    });
</script>

<?= $this->endSection() ?>