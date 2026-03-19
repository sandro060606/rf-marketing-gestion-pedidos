<!--
Historial de Pedidos del Cliente
Muestra métricas de resumen y una tabla con los requerimientos -->

<!-- Heredado -->
<?= $this->extend('plantillas/cliente') ?>
<!-- Plantilla para Inyeccion Datos -->
<?= $this->section('contenido') ?>

<!-- Encabezado -->
<div class="seccion-titulo" style="font-size:14px;">MIS PEDIDOS</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <!-- Nombre del Cliente -->
        <h2 class="bebas mb-0" style="font-size:2rem; letter-spacing:1px;">
            <?= session()->get('nombre') ?>
        </h2>
        <p class="small mb-0" style="font-size:14px; color:#aaa;">
            <?= session()->get('area') ?? 'Cliente' ?> — Historial de requerimientos
        </p>
    </div>
    <a href="<?= base_url('cliente/nuevo-pedido') ?>" class="btn-rf">
        <i class="bi bi-plus-lg"></i> Nuevo Pedido
    </a>
</div>

<!-- Métricas resumen -->
<div class="seccion-titulo" style="font-size:14px;">RESUMEN</div>
<div class="row g-2 mb-4">
    <!-- Por Aprobar -->
    <div class="col-6 col-md-3">
        <div class="card p-3">
            <div class="met-label">Por Aprobar</div>
            <div class="met-num amarillo">
                <!-- Filtra el array de pedidos para contar solo los estados 'por_aprobar' -->
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
                <!-- Filtra el array de pedidos para contar solo los estados 'en_proceso' -->
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
                <!-- Filtra el array de pedidos para contar solo los estados 'completado' -->
                <?= count(array_filter($pedidos, fn($p) => $p['estado'] === 'completado')) ?>
            </div>
            <div class="met-sub">Total histórico</div>
        </div>
    </div>
    <!-- Total -->
    <div class="col-6 col-md-3">
        <div class="card p-3">
            <div class="met-label">Total</div>
            <!-- Cuenta Todos los Registros del Array (Pedidos) -->
            <div class="met-num" style="color:#f0f0f0"><?= count($pedidos) ?></div>
            <div class="met-sub">Todos los pedidos</div>
        </div>
    </div>

</div>

<!-- Tabla de pedidos -->
<div class="seccion-titulo" style="font-size:14px;">TODOS LOS PEDIDOS</div>

<div class="card" style="overflow:hidden;">
    <!-- Header tabla con buscador -->
    <div class="tabla-header">
        <div class="buscador-wrap">
            <i class="bi bi-search" style="color:#555; font-size:12px;"></i>
            <input type="text" id="buscador" placeholder="Buscar pedido..." class="input-buscar">
        </div>
    </div>

    <div class="table-responsive">
        <!-- Tabla -->
        <table class="tabla-rf" id="tablaPedidos">
            <!-- Encabezado -->
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
            <!-- Registros -->
            <tbody>
                <?php if (empty($pedidos)): ?>
                    <tr>
                        <td colspan="7" class="estado-vacio">
                            <i class="bi bi-inbox"></i>
                            <p>Aún no tienes pedidos registrados</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <!-- Total de Pedidos -->
                    <?php $numero = count($pedidos); ?>
                    <!-- Buscar y Repetir Estructura x Pedido Encontrado -->
                    <?php foreach ($pedidos as $pedido): ?>
                        <!-- Fila de la tabla con atributo de datos para referencia CSS o JS -->
                        <tr data-numero="<?= $numero ?>">
                            <!-- Contador Inverso, Mas Reciente al Mas Antiguo -->
                            <td style="color:#555; font-size:11px;">#<?= $numero-- ?></td>
                            <!-- Titulo -->
                            <td>
                                <?php if ($pedido['titulo']): ?>
                                    <span style="font-weight:600; font-size:13px;">
                                        <?= esc($pedido['titulo']) ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color:#777; font-style:italic">
                                        Pendiente de revisión
                                    </span>
                                <?php endif; ?>
                            </td>
                            <!-- Servicio -->
                            <td>
                                <span class="area-btn" style="cursor:default;">
                                    <?= esc($pedido['servicio']) ?>
                                </span>
                            </td>
                            <!-- Estado -->
                            <td>
                                <?= badge_estado($pedido['estado']) ?>
                            </td>
                            <!-- Prioridad -->
                            <td>
                                <?php if ($pedido['prioridad']): ?>
                                    <?= badge_prioridad($pedido['prioridad']) ?>
                                <?php else: ?>
                                    <span style="color:#555;">—</span>
                                <?php endif; ?>
                            </td>
                            <!-- Fecha -->
                            <td style="color:#777; font-size:11px;">
                                <?= formato_fecha($pedido['fechacreacion']) ?>
                            </td>
                            <!-- Enlace a una Vista mas Detallada del Pedido -->
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
<?= $this->endSection() ?>
<!-- Agregar Enlace de JS en una Nueva Seccion -->
<?= $this->section('scripts') ?>
<script src="<?= base_url('recursos/scripts/paginas/mis-pedidos.js') ?>"></script>
<?= $this->endSection() ?>