<?= $this->extend('plantillas/cliente') ?>
<?= $this->section('contenido') ?>

<div class="seccion-titulo">NUEVO PEDIDO</div>
<h2 class="bebas" style="font-size:2rem;">
    <?= esc($servicio['nombre']) ?>
</h2>
<p style="color:#888; font-size:13px;">Formulario en construcción — próximamente aquí</p>
<a href="<?= base_url('cliente/nuevo-pedido') ?>" style="color:#F5C400; font-size:13px;">
    ← Volver a selección de servicio
</a>

<?= $this->endSection() ?>