<?= $this->extend('plantillas/principal') ?>  

<?= $this->section('styles') ?>  <!-- Sección de estilos -->
<link href="<?= base_url('recursos/styles/paginas/panel.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('contenido') ?> 

<p class="seccion-titulo">Todas las Empresas</p>  

<?php foreach ($empresas as $empresa) : ?>  <!-- Loop sobre cada empresa -->
    <div class="emp-list-item" onclick="window.location.href='<?= base_url('admin/empresas/panel/'.$empresa['id']) ?>'">  <!-- Fila de empresa-->
        <div class="clogo" style="background:<?= $empresa['color'] ?>;width:40px;height:40px;font-size:17px;">  <!-- Cuadro de color con inicial -->
            <?= esc($empresa['inicial']) ?>
        </div>
        <div class="eli-info">  <!-- Información de la empresa -->
            <div class="eli-name"><?= esc($empresa['nombreempresa']) ?></div>  <!-- Nombre -->
            <div class="eli-sub">RUC <?= esc($empresa['ruc']) ?> &nbsp;·&nbsp; <?= esc($empresa['correo']) ?> &nbsp;·&nbsp; <?= esc($empresa['telefono']) ?></div>  <!-- Detalles -->
        </div>
        <div class="eli-stats">  <!-- Estadísticas -->
            <?php if ($empresa['por_aprobar'] > 0) : ?>  <!-- Solo mostrar si hay por aprobar -->
                <div class="eli-stat">
                    <div class="eli-stat-n" style="color:#c084fc"><?= $empresa['por_aprobar'] ?></div> 
                    <div class="eli-stat-l">Por aprobar</div>
                </div>
            <?php endif ?>
            <div class="eli-stat">
                <div class="eli-stat-n" style="color:#F5C400"><?= $empresa['activos'] ?></div>  
                <div class="eli-stat-l">Activos</div>
            </div>
            <div class="eli-stat">
                <div class="eli-stat-n" style="color:#22c55e"><?= $empresa['completados'] ?></div>  
                <div class="eli-stat-l">Completados</div>
            </div>
        </div>
        <button class="btn-sm" onclick="event.stopPropagation();window.location.href='<?= base_url('admin/empresas/panel/'.$empresa['id']) ?>'">Ver panel →</button>  <!-- Botón para ver panel -->
    </div>
<?php endforeach ?>

<?= $this->endSection() ?>