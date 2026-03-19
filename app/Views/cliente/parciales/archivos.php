<!-- Condicional para Archivos de Entrada -->
<?php if (!empty($archivos['entradas'])): ?>
    <div class="seccion-titulo">ARCHIVOS ADJUNTOS</div>
    <div class="card p-3 mb-3">
        <?php foreach ($archivos['entradas'] as $a): ?>
            <div class="archivo-fila">
                <i class="bi bi-paperclip" style="color:#555;"></i>
                <!-- Nombre Archivo -->
                <span style="font-size:12px;color:#aaa;flex:1;">
                    <?= esc($a['nombre']) ?>
                </span>
                <!-- Enlace para Vizualizar / Descarga -->
                <a href="<?= base_url($a['ruta']) ?>" class="btn-descargar me-1" target="_blank"><i class="bi bi-eye"></i></a>
                <a href="<?= base_url($a['ruta']) ?>" class="btn-descargar" download><i class="bi bi-download"></i></a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Condicional para Archivos Entregados -->
<?php if (!empty($archivos['entregables'])): ?>
    <div class="seccion-titulo">ENTREGABLES</div>
    <div class="card p-3 mb-3">
        <?php foreach ($archivos['entregables'] as $a): ?>
            <div class="archivo-fila">
                <i class="bi bi-file-earmark-arrow-down-fill" style="color:#22c55e;"></i>
                <!-- Nombre Archivo -->
                <span style="font-size:12px;color:#aaa;flex:1;">
                    <?= esc($a['nombre']) ?>
                </span>
                <!-- Enlace para Vizualizar / Descarga -->
                <a href="<?= base_url($a['ruta']) ?>" class="btn-descargar me-1" target="_blank"><i class="bi bi-eye"></i></a>
                <a href="<?= base_url($a['ruta']) ?>" class="btn-descargar" download><i class="bi bi-download"></i></a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>