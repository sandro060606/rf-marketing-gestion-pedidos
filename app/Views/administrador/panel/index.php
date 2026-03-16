<?= $this->extend('plantillas/principal') ?>

<?= $this->section('estilos') ?>
<link href="<?= base_url('recursos/styles/paginas/panel.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<!-- Métricas -->
<p class="seccion-titulo">Resumen</p>

<div class="row g-2 mb-3">
    <div class="col-3">
        <div class="card p-3">
            <div class="metrica-etiqueta">Pedidos Activos</div>
            <div class="metrica-numero" style="color:var(--amarillo)"><?= $activos ?? 0 ?></div>
        </div>
    </div>
    <div class="col-3">
        <div class="card p-3">
            <div class="metrica-etiqueta">Por Aprobar</div>
            <div class="metrica-numero" style="color:var(--morado)"><?= $porAprobar ?? 0 ?></div>
        </div>
    </div>
    <div class="col-3">
        <div class="card p-3">
            <div class="metrica-etiqueta">Completados</div>
            <div class="metrica-numero" style="color:var(--verde)"><?= $completados ?? 0 ?></div>
        </div>
    </div>
    <div class="col-3">
        <div class="card p-3">
            <div class="metrica-etiqueta">Sin Asignar</div>
            <div class="metrica-numero" style="color:var(--rojo)"><?= $sinAsignar ?? 0 ?></div>
        </div>
    </div>
</div>
<!-- Empresas -->
<p class="seccion-titulo">Empresas</p>

<?php if (empty($empresas)) : ?>
    <div class="estado-vacio">
        <i class="bi bi-building"></i>
        <p>No hay empresas registradas todavía.</p>
    </div>
<?php else : ?>
    <div class="row g-2">
        <?php foreach ($empresas as $empresa) : ?>
        <div class="col-6">
            <div class="card p-3">
                <strong><?= esc($empresa['nombreempresa']) ?></strong>
            </div>
        </div>
        <?php endforeach ?>
    </div>
<?php endif ?>
<?= $this->endSection() ?>