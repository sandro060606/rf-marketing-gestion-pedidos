<?= $this->extend('plantillas/cliente') ?>
<?= $this->section('contenido') ?>

<div class="seccion-titulo">NUEVO PEDIDO</div>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?= base_url('cliente/nuevo-pedido') ?>" class="btn-volver">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <p style="font-size:10px; color:#555; margin:0; letter-spacing:2px; text-transform:uppercase;">
            <?= esc($servicio['nombre']) ?>
        </p>
        <h2 class="bebas mb-0" style="font-size:1.8rem; letter-spacing:2px;">
            FORMULARIO DE REQUERIMIENTO
        </h2>
    </div>
</div>

<!-- Indicador de pasos -->
<div class="wizard-steps mb-4">
    <div class="wizard-step active" id="ind-1">
        <div class="step-num">1</div>
        <span class="step-label">Información Básica</span>
    </div>
    <div class="wizard-linea"></div>
    <div class="wizard-step" id="ind-2">
        <div class="step-num">2</div>
        <span class="step-label">Detalles</span>
    </div>
    <div class="wizard-linea"></div>
    <div class="wizard-step" id="ind-3">
        <div class="step-num">3</div>
        <span class="step-label">Confirmar</span>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alerta-error mb-3">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('cliente/nuevo-pedido') ?>" method="POST" id="wizardForm" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="idservicio" value="<?= $servicio['id'] ?>">
    <input type="hidden" name="prioridad" value="media" id="campoPrioridad">
    <input type="hidden" name="tiene_materiales" value="false">

    <!-- PASO 1 -->
    <div class="wizard-panel active" id="paso-1">
        <div class="form-card">
            <div class="form-card-titulo">INFORMACIÓN BÁSICA</div>
            <div class="campo-grupo">
                <label class="campo-label">Título del pedido <span class="obligatorio">*</span></label>
                <input type="text" name="titulo" class="campo-input" placeholder="Ej: Afiche graduación 2026"
                    value="<?= old('titulo') ?>" required>
                <small class="campo-ayuda">Nombre corto que identifique este requerimiento.</small>
            </div>
            <div class="campo-grupo">
                <label class="campo-label">Área solicitante <span class="obligatorio">*</span></label>
                <input type="text" name="area" class="campo-input" placeholder="Ej: Dirección Académica"
                    value="<?= old('area') ?>" required>
            </div>
            <div class="campo-grupo">
                <label class="campo-label">Objetivo de la comunicación <span class="obligatorio">*</span></label>
                <textarea name="objetivo_comunicacion" class="campo-textarea" rows="3"
                    placeholder="Idea principal. Menciona a quién va dirigido."
                    required><?= old('objetivo_comunicacion') ?></textarea>
            </div>
            <div class="campo-grupo">
                <label class="campo-label">Fecha en que se usará <span class="obligatorio">*</span></label>
                <input type="date" name="fecharequerida" class="campo-input" value="<?= old('fecharequerida') ?>"
                    min="<?= date('Y-m-d', strtotime('+2 days')) ?>" required>
                <small class="campo-ayuda">
                    Plazos: Adaptación 2 días · Creación 4 días · Video/Editorial 7+ días hábiles.
                </small>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button type="button" class="btn-wizard-next" onclick="validarYsiguiente(1)">
                Siguiente <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </div>

    <!-- PASO 2 -->
    <div class="wizard-panel" id="paso-2">
        <div class="form-card">
            <div class="form-card-titulo">DETALLES DEL REQUERIMIENTO</div>
            <div class="campo-grupo">
                <label class="campo-label">Descripción detallada <span class="obligatorio">*</span></label>
                <textarea name="descripcion" class="campo-textarea" rows="4"
                    placeholder="Incluye TEXTO EXACTO: título, fecha, hora, lugar, logos, etc."
                    required><?= old('descripcion') ?></textarea>
            </div>
            <div class="campo-grupo">
                <label class="campo-label">Tipo de requerimiento <span class="obligatorio">*</span></label>
                <?php foreach ($tipos as $tipo): ?>
                    <label class="opcion-radio">
                        <input type="radio" name="tipo_requerimiento" value="<?= $tipo ?>"
                            <?= old('tipo_requerimiento') === $tipo ? 'checked' : '' ?> required>
                        <span><?= $tipo ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="campo-grupo">
                <label class="campo-label">
                    ¿Dónde se difundirá?
                    <small style="color:#555; font-weight:400;"> — Máximo 3</small>
                </label>
                <div class="opciones-grid">
                    <?php foreach ($canales as $canal): ?>
                        <label class="opcion-check">
                            <input type="checkbox" name="canales_difusion[]" value="<?= $canal ?>" class="check-canal">
                            <span><?= $canal ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="campo-grupo">
                <label class="campo-label">¿A quién nos dirigimos?</label>
                <textarea name="publico_objetivo" class="campo-textarea" rows="2"
                    placeholder="Perfil y tono (formal o amigable)."><?= old('publico_objetivo') ?></textarea>
            </div>
            <div class="campo-grupo">
                <label class="campo-label">Formato solicitado</label>
                <div class="opciones-grid">
                    <?php foreach ($formatos as $formato): ?>
                        <label class="opcion-check">
                            <input type="checkbox" name="formatos_solicitados[]" value="<?= $formato ?>"
                                class="check-formato" onchange="toggleOtros()">
                            <span><?= $formato ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="campo-grupo" id="campoOtros" style="display:none;">
                <label class="campo-label">Especifica formato y medidas</label>
                <input type="text" name="formato_otros" class="campo-input" placeholder="Ej: Banner 3x1 metros"
                    value="<?= old('formato_otros') ?>">
            </div>
        </div>
        <div class="d-flex justify-content-between mt-3">
            <button type="button" class="btn-wizard-back" onclick="irPaso(1)">
                <i class="bi bi-arrow-left me-1"></i> Anterior
            </button>
            <button type="button" class="btn-wizard-next" onclick="validarYsiguiente(2)">
                Siguiente <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </div>

    <!-- PASO 3 -->
    <div class="wizard-panel" id="paso-3">
        <div class="form-card mb-3">
            <div class="form-card-titulo">PRIORIDAD</div>
            <div class="campo-grupo" style="margin-bottom:0;">
                <label class="campo-label">¿Qué tan urgente es?</label>
                <div class="d-flex gap-3 mt-2">
                    <label class="opcion-prioridad" onclick="setPrioridad('baja', this)">
                        <span class="prio-dot" style="background:#22c55e;"></span> Baja
                    </label>
                    <label class="opcion-prioridad active" onclick="setPrioridad('media', this)">
                        <span class="prio-dot" style="background:#f97316;"></span> Media
                    </label>
                    <label class="opcion-prioridad" onclick="setPrioridad('alta', this)">
                        <span class="prio-dot" style="background:#ef4444;"></span> Alta
                    </label>
                </div>
            </div>
        </div>

        <!-- Archivos -->
        <div class="form-card mb-3">
            <div class="form-card-titulo">
                ARCHIVOS DE REFERENCIA
                <small style="color:#555; font-weight:400; letter-spacing:0;">(Opcional)</small>
            </div>
            <small class="campo-ayuda mb-2 d-block">
                Logos, fotos, briefs, videos. Máx 500MB. Formatos: jpg, png, pdf, ai, psd, mp4, zip
            </small>
            <div id="zona-drop" onclick="document.getElementById('inputArchivos').click()">
                <i class="bi bi-cloud-arrow-up-fill"></i>
                <p>Arrastra archivos aquí o <span>haz clic para seleccionar</span></p>
                <small>Múltiples archivos permitidos</small>
            </div>
            <input type="file" id="inputArchivos" multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.ai,.psd,.mp4,.zip"
                style="display:none;">
            <div id="lista-archivos"></div>
            <input type="hidden" name="archivos_rutas" id="archivos_rutas">
        </div>

        <!-- Resumen -->
        <div class="form-card mb-3">
            <div class="form-card-titulo">RESUMEN</div>
            <div class="resumen-fila">
                <span class="resumen-label">Empresa</span>
                <span class="resumen-valor"><?= esc($empresa['nombreempresa'] ?? session()->get('empresa')) ?></span>
            </div>
            <div class="resumen-fila">
                <span class="resumen-label">Servicio</span>
                <span class="resumen-valor"><?= esc($servicio['nombre']) ?></span>
            </div>
            <div class="resumen-fila">
                <span class="resumen-label">Título</span>
                <span class="resumen-valor" id="res-titulo">—</span>
            </div>
            <div class="resumen-fila">
                <span class="resumen-label">Área</span>
                <span class="resumen-valor" id="res-area">—</span>
            </div>
            <div class="resumen-fila">
                <span class="resumen-label">Tipo</span>
                <span class="resumen-valor" id="res-tipo">—</span>
            </div>
            <div class="resumen-fila">
                <span class="resumen-label">Fecha requerida</span>
                <span class="resumen-valor" id="res-fecha">—</span>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="button" class="btn-wizard-back" onclick="irPaso(2)">
                <i class="bi bi-arrow-left me-1"></i> Anterior
            </button>
            <button type="submit" class="btn-enviar">
                <i class="bi bi-send-fill me-2"></i> Enviar Pedido
            </button>
        </div>
    </div>
</form>

<?php $js_extra = '<script>window.BASE_URL = "' . base_url() . '/";</script>
<script src="' . base_url('recursos/scripts/paginas/formulario.js') . '"></script>'; ?>

<?= $this->endSection() ?>