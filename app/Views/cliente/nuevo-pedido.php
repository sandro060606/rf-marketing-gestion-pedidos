<?= $this->extend('plantillas/cliente') ?>
<?= $this->section('contenido') ?>

<!-- Encabezado -->
<div class="seccion-titulo"  style="font-size:13px; color:#aaa;" >NUEVO PEDIDO</div>

<div class="mb-4">
    <h2 class="bebas mb-0" style="font-size:2rem; letter-spacing:2px;">
        ¿QUÉ TIPO DE REQUERIMIENTO NECESITAS?
    </h2>
    <p style="font-size:13px; color:#aaa; margin:0;">
        Selecciona el servicio para continuar con el formulario correspondiente.
    </p>
</div>

<!--  Consideraciones importantes -->
<div class="aviso-card mb-4">
    <div class="aviso-icono"><i class="bi bi-info-circle-fill"></i></div>
    <div>
        <p class="aviso-titulo">CONSIDERA LOS PLAZOS DE ENTREGA</p>
        <div class="aviso-items">
            <span><i class="bi bi-clock"></i> Adaptación de Arte — <strong>2 días hábiles</strong></span>
            <span><i class="bi bi-clock"></i> Creación de Arte — <strong>4 días hábiles</strong></span>
            <span><i class="bi bi-clock"></i> Creación de Video — <strong>mínimo 7 días hábiles</strong></span>
            <span><i class="bi bi-clock"></i> Video / Editorial — <strong>mínimo 7 días hábiles</strong></span>
        </div>
        <p class="aviso-sub" style="font-size:13px; color:#aaa;">
            Los pedidos se reciben únicamente por este sistema
        </p>
    </div>
</div>

<!-- Tarjetas de servicio -->
<!-- Los servicios vienen de la BD via $servicios (array)-->
<div class="seccion-titulo" style="font-size:13px; color:#aaa;" >SELECCIONA UN SERVICIO</div>

<div class="servicios-grid">
    <?php foreach ($servicios as $servicio): ?>

    <?php
    // Asignar ícono y color según el nombre del servicio
    $nombre = strtolower($servicio['nombre']);
    if (str_contains($nombre, 'diseño') || str_contains($nombre, 'grafico') || str_contains($nombre, 'gráfico')):
        $icono = 'bi-palette-fill';
        $color = '#F5C400';
        $colorBg = 'rgba(245,196,0,0.08)';
        $colorBorder = 'rgba(245,196,0,0.2)';
        $tag = 'DISEÑO GRÁFICO';
    elseif (str_contains($nombre, 'audio') || str_contains($nombre, 'video') || str_contains($nombre, 'visual')):
        $icono = 'bi-camera-video-fill';
        $color = '#60a5fa';
        $colorBg = 'rgba(96,165,250,0.08)';
        $colorBorder = 'rgba(96,165,250,0.2)';
        $tag = 'AUDIOVISUAL';
    else:
        $icono = 'bi-briefcase-fill';
        $color = '#c084fc';
        $colorBg = 'rgba(192,132,252,0.08)';
        $colorBorder = 'rgba(192,132,252,0.2)';
        $tag = 'SERVICIO';
    endif;
    ?>

    <a href="<?= base_url('cliente/nuevo-pedido/' . $servicio['id']) ?>"
       class="servicio-card"
       style="--card-color: <?= $color ?>; --card-bg: <?= $colorBg ?>; --card-border: <?= $colorBorder ?>;">

        <!-- Ícono grande -->
        <div class="servicio-icono">
            <i class="bi <?= $icono ?>"></i>
        </div>

        <!-- Info -->
        <div class="servicio-info">
            <span class="servicio-tag"><?= $tag ?></span>
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