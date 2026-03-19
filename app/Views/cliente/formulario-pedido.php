<<<<<<< HEAD
=======

<!-- Heredado -->
>>>>>>> 701a192 (Reestructuracion de Modulos, realizando Buenas Practicas con el Codigo)
<?= $this->extend('plantillas/cliente') ?>
<!-- Plantilla para Inyeccion -->
<?= $this->section('contenido') ?>

<<<<<<< HEAD
<div class="seccion-titulo">NUEVO PEDIDO</div>
<h2 class="bebas" style="font-size:2rem;">
    <?= esc($servicio['nombre']) ?>
</h2>
<p style="color:#888; font-size:13px;">Formulario en construcción — próximamente aquí</p>
<a href="<?= base_url('cliente/nuevo-pedido') ?>" style="color:#F5C400; font-size:13px;">
    ← Volver a selección de servicio
</a>
=======
<!-- Titulo de Seccion -->
<div class="seccion-titulo">NUEVO PEDIDO</div>

<!-- Encabezado -->
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?= base_url('cliente/nuevo-pedido') ?>" class="btn-volver">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <!-- Nombre del Servicio -->
        <p style="font-size:10px; color:#555; margin:0; letter-spacing:2px; text-transform:uppercase;">
            <?= esc($servicio['nombre']) ?>
        </p>
        <h2 class="bebas mb-0" style="font-size:1.8rem; letter-spacing:2px;">
            FORMULARIO DE REQUERIMIENTO
        </h2>
    </div>
</div>
<!-- Vista Temporal para el Formulario -->
<div class="card p-4 text-center" style="color:#555;">
    <i class="bi bi-file-earmark-text" style="font-size:32px; display:block; margin-bottom:12px;"></i>
    <p style="font-size:14px; margin:0;">
        Aquí irá el formulario de <strong style="color:#f0f0f0;"><?= esc($servicio['nombre']) ?></strong>
    </p>
    <p style="font-size:12px; margin-top:6px; color:#444;">— En construcción —</p>
</div>
>>>>>>> 701a192 (Reestructuracion de Modulos, realizando Buenas Practicas con el Codigo)

<?= $this->endSection() ?>