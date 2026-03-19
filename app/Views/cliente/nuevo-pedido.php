<<<<<<< HEAD
<?php
// ARCHIVO: app/Views/cliente/nuevo-pedido.php
// Hereda: plantillas/cliente.php
// Recibe: $servicios (array desde ServicioModel)
// Pantalla 0 — El cliente elige el tipo de servicio antes del wizard
?>

=======
<!-- 
Selector de Requerimientos
Categoriza visualmente los servicios disponibles y establece las políticas de tiempos de entrega-->

<!-- Hereda -->
>>>>>>> 701a192 (Reestructuracion de Modulos, realizando Buenas Practicas con el Codigo)
<?= $this->extend('plantillas/cliente') ?>
<!-- Plantilla para la Inyeccion -->
<?= $this->section('contenido') ?>

<!-- Encabezado -->
<div class="seccion-titulo" style="font-size:13px; color:#aaa;">NUEVO PEDIDO</div>

<!-- Titulo Principal -->
<div class="mb-4">
    <h2 class="bebas mb-0" style="font-size:2rem; letter-spacing:2px;">
        ¿QUÉ TIPO DE REQUERIMIENTO NECESITAS?
    </h2>
    <p style="font-size:13px; color:#aaa; margin:0;">
        Selecciona el servicio para continuar con el formulario correspondiente.
    </p>
</div>

<!--  Politicas de Tiempo -->
<div class="aviso-card mb-4">
    <div class="aviso-icono"><i class="bi bi-info-circle-fill"></i></div>
    <div>
        <p class="aviso-titulo">CONSIDERA LOS PLAZOS DE ENTREGA</p>
        <div class="aviso-items">
            <span><i class="bi bi-clock"></i> Adaptación de Arte — <strong>2 días hábiles</strong></span>
            <span><i class="bi bi-clock"></i> Creación de Arte — <strong>4 días hábiles</strong></span>
            <span><i class="bi bi-clock"></i> Video / Editorial — <strong>mínimo 7 días hábiles</strong></span>
        </div>
        <p class="aviso-sub" style="font-size:13px; color:#aaa;">
            Los pedidos se reciben únicamente por este sistema
        </p>
    </div>
</div>

<!-- Tarjetas de servicio Dinamico -->
<!-- Los servicios vienen de la BD via $servicios (array)-->
<div class="seccion-titulo" style="font-size:13px; color:#aaa;">SELECCIONA UN SERVICIO</div>

<div class="servicios-grid">
    <?php
    foreach ($servicios as $servicio):
        $estilo = obtener_estilo_servicio($servicio['nombre']);
        ?>
        <!-- Genera la ruta absoluta hacia el formulario del servicio -->
        <a href="<?= base_url('cliente/nuevo-pedido/' . $servicio['id']) ?>" class="servicio-card"
            style="--card-color: <?= $estilo['color'] ?>; --card-bg: <?= $estilo['bg'] ?>; --card-border: <?= $estilo['border'] ?>;">
            <!-- Ícono grande -->
            <div class="servicio-icono">
                <i class="bi <?= $estilo['icono'] ?>"></i>
            </div>
            <!-- Info -->
            <div class="servicio-info">
                <span class="servicio-tag"><?= $estilo['tag'] ?></span>
                <h3 class="servicio-nombre bebas"><?= esc($servicio['nombre']) ?></h3>
                <?php if (!empty($servicio['descripcion'])): ?>
                    <p class="servicio-desc" style="font-size:13px; color:#aaa;"><?= esc($servicio['descripcion']) ?></p>
                <?php endif; ?>
            </div>
            <!-- Flecha -->
            <div class="servicio-arrow">
                <i class="bi bi-arrow-right-circle-fill"></i>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>