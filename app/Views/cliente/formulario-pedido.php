<?php
$esAudiovisual = $servicio['id'] === 2;

$tipos = $esAudiovisual ? [
    'Adaptación de Arte',
    'Creación de Arte',
    'Creación de Videos',
    'Creación de Editorial',
    'Adaptación de Editorial',
    'Modificación Web',
] : [
    'Adaptación de Arte',
    'Creación de Arte',
    'Creación de Editorial',
    'Adaptación de Editorial',
    'Modificación Pagina Web',
];

// Canales de difusión
$canales = [
    'Por correo',
    'Página web',
    'Redes sociales',
    'SIGU o Aula Virtual Estudiantes',
    'SIGU o Aula Virtual Docentes',
    'Impresión física de folletos',
    'Banner físico',
    'Letreros',
    'Merch para eventos específicos',
];

// Formatos según servicio
$formatos = $esAudiovisual ? [
    'Reels de Facebook/Instagram',
    'Historia Facebook/Instagram',
    'Reel/Historia TikTok',
    'Reels de LinkedIn',
    'Historia de Whatsapp',
    'Video para Youtube',
    'SIGU (comunicado)',
    'Aula Virtual (Pop up)',
    'Pantallas LED publicitarias',
    'Spot publicitario para TV',
    'Videos para proyección de eventos',
    'Reels para Pauta',
    'Otros',
] : [
    'Emailing',
    'Post de Facebook/Instagram',
    'Historia Facebook/Instagram',
    'Historia de Whatsapp',
    'Post de LinkedIn',
    'SIGU (comunicado)',
    'Aula Virtual (Pop up)',
    'Wallpaper – Computadoras',
    'Banner Web Portada',
    'Volante A5',
    'Afiche A4',
    'Afiche A3',
    'Credenciales',
    'Banner 2x1',
    'Tarjeta Personal',
    'Tríptico',
    'Díptico',
    'Folder A4',
    'Brochure',
    'Cartilla',
    'Banderola',
    'Módulos',
    'SMS',
    'IVR',
    'Marcos Selfie',
    'Boletín',
    'Guías',
    'Imagen JPG - PNG',
    'Otros',
];
?>

<?= $this->extend('plantillas/cliente') ?>
<?= $this->section('contenido') ?>

<!-- Encabezado  -->
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

<!-- Alertas flash -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alerta-error mb-3">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Formulario -->
<form action="<?= base_url('cliente/nuevo-pedido') ?>" method="POST" id="wizardForm" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="idservicio" value="<?= $servicio['id'] ?>">
    <input type="hidden" name="prioridad" value="media" id="campoPrioridad">
    <input type="hidden" name="tiene_materiales" value="false" id="campoMateriales">

    <!--PASO 1 — Información Básica -->
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
                    placeholder="Idea principal que queremos comunicar. Menciona a quién va dirigido."
                    required><?= old('objetivo_comunicacion') ?></textarea>
            </div>

            <div class="campo-grupo">
                <label class="campo-label">Fecha en que se usará el requerimiento <span
                        class="obligatorio">*</span></label>
                <input type="date" name="fecharequerida" class="campo-input" value="<?= old('fecharequerida') ?>"
                    min="<?= date('Y-m-d', strtotime('+2 days')) ?>" required>
                <small class="campo-ayuda">
                    Plazos: Adaptación 2 días · Creación de Arte 4 días · Video/Editorial mínimo 7 días hábiles.
                </small>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="button" class="btn-wizard-next" onclick="validarYsiguiente(1)">
                Siguiente <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </div>

    <!-- PASO 2 — Detalles -->
    <div class="wizard-panel" id="paso-2">
        <div class="form-card">
            <div class="form-card-titulo">DETALLES DEL REQUERIMIENTO</div>

            <div class="campo-grupo">
                <label class="campo-label">Descripción detallada <span class="obligatorio">*</span></label>
                <textarea name="descripcion" class="campo-textarea" rows="4"
                    placeholder="Detalla la campaña o actividad. Incluye TEXTO EXACTO: título, fecha, hora, lugar, logos, etc."
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
                    ¿Dónde se va a difundir?
                    <small style="color:#555; font-weight:400;"> — Máximo 3 opciones</small>
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
                    placeholder="Perfil de personas y tono (formal o amigable)."><?= old('publico_objetivo') ?></textarea>
            </div>

            <div class="campo-grupo">
                <label class="campo-label">Formato solicitado</label>
                <div class="opciones-grid">
                    <?php foreach ($formatos as $formato): ?>
                        <label class="opcion-check">
                            <input type="checkbox" name="formatos_solicitados[]" value="<?= $formato ?>"
                                class="check-formato" onchange="toggleOtros(this)">
                            <span><?= $formato ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Campo otros — solo si seleccionó "Otros" -->
            <div class="campo-grupo" id="campoOtros" style="display:none;">
                <label class="campo-label">Especifica el formato y medidas</label>
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

    <!-- PASO 3 — Confirmar y Enviar -->
    <div class="wizard-panel" id="paso-3">
        <div class="form-card mb-3">
            <div class="form-card-titulo">PRIORIDAD</div>

            <div class="campo-grupo" style="margin-bottom:0;">
                <label class="campo-label">¿Qué tan urgente es este pedido?</label>
                <div class="d-flex gap-3 mt-2">
                    <label class="opcion-prioridad" onclick="setPrioridad('baja', this)">
                        <span class="prio-dot" style="background:#22c55e;"></span>
                        Baja
                    </label>
                    <label class="opcion-prioridad active" onclick="setPrioridad('media', this)">
                        <span class="prio-dot" style="background:#f97316;"></span>
                        Media
                    </label>
                    <label class="opcion-prioridad" onclick="setPrioridad('alta', this)">
                        <span class="prio-dot" style="background:#ef4444;"></span>
                        Alta
                    </label>
                </div>
            </div>
            <!-- Archivos adjuntos opcionales -->
            <div class="form-card mb-3">
                <div class="form-card-titulo">ARCHIVOS DE REFERENCIA <small
                        style="color:#555; font-weight:400; letter-spacing:0;">(Opcional)</small></div>

                <div class="campo-grupo" style="margin-bottom:0;">
                    <label class="campo-label">Adjunta materiales de referencia</label>
                    <small class="campo-ayuda mb-2 d-block">
                        Logos, fotos, briefs, referencias visuales. Máx 50MB por archivo.
                        Formatos: jpg, png, pdf, ai, psd, mp4, zip
                    </small>
                    <input type="file" name="archivos[]" class="campo-archivo" multiple
                        accept=".jpg,.jpeg,.png,.gif,.pdf,.ai,.psd,.mp4,.zip">
                </div>
            </div>
        </div>

        <!-- Resumen del pedido -->
        <div class="form-card mb-3">
            <div class="form-card-titulo">RESUMEN DEL PEDIDO</div>
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

<script>
    // Navegar entre pasos
    function irPaso(num) {
        document.querySelectorAll('.wizard-panel').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.wizard-step').forEach(s => s.classList.remove('active', 'completado'));

        document.getElementById('paso-' + num).classList.add('active');

        for (let i = 1; i <= 3; i++) {
            const ind = document.getElementById('ind-' + i);
            if (i < num) ind.classList.add('completado');
            if (i === num) ind.classList.add('active');
        }

        // Actualizar resumen en paso 3
        if (num === 3) actualizarResumen();

        window.scrollTo(0, 0);
    }

    // Validar campos del paso antes de avanzar
    function validarYsiguiente(paso) {
        if (paso === 1) {
            const titulo = document.querySelector('[name="titulo"]').value.trim();
            const area = document.querySelector('[name="area"]').value.trim();
            const obj = document.querySelector('[name="objetivo_comunicacion"]').value.trim();
            const fecha = document.querySelector('[name="fecharequerida"]').value.trim();

            if (!titulo || !area || !obj || !fecha) {
                mostrarError('Completa todos los campos obligatorios antes de continuar.');
                return;
            }
        }

        if (paso === 2) {
            const tipo = document.querySelector('[name="tipo_requerimiento"]:checked');
            const desc = document.querySelector('[name="descripcion"]').value.trim();

            if (!desc || !tipo) {
                mostrarError('Selecciona el tipo de requerimiento y completa la descripción.');
                return;
            }
        }

        ocultarError();
        irPaso(paso + 1);
    }

    // Máximo 3 canales
    document.querySelectorAll('.check-canal').forEach(function (check) {
        check.addEventListener('change', function () {
            const marcados = document.querySelectorAll('.check-canal:checked');
            if (marcados.length > 3) {
                this.checked = false;
                mostrarError('Puedes seleccionar máximo 3 canales de difusión.');
            } else {
                ocultarError();
            }
        });
    });

    // Mostrar campo "Otros" si se selecciona
    function toggleOtros(check) {
        const campoOtros = document.getElementById('campoOtros');
        const otrosMarcado = document.querySelector('[name="formatos_solicitados[]"][value="Otros"]');
        campoOtros.style.display = (otrosMarcado && otrosMarcado.checked) ? 'block' : 'none';
    }

    // Prioridad
    function setPrioridad(valor, el) {
        document.getElementById('campoPrioridad').value = valor;
        document.querySelectorAll('.opcion-prioridad').forEach(o => o.classList.remove('active'));
        el.classList.add('active');
    }

    // Actualizar resumen en paso 3
    function actualizarResumen() {
        document.getElementById('res-titulo').textContent =
            document.querySelector('[name="titulo"]').value || '—';
        document.getElementById('res-area').textContent =
            document.querySelector('[name="area"]').value || '—';
        document.getElementById('res-fecha').textContent =
            document.querySelector('[name="fecharequerida"]').value || '—';

        const tipo = document.querySelector('[name="tipo_requerimiento"]:checked');
        document.getElementById('res-tipo').textContent = tipo ? tipo.value : '—';
    }

    // Mensajes de error inline
    function mostrarError(msg) {
        let el = document.getElementById('wizard-error');
        if (!el) {
            el = document.createElement('div');
            el.id = 'wizard-error';
            el.className = 'alerta-error mb-3';
            document.getElementById('wizardForm').prepend(el);
        }
        el.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>' + msg;
        el.style.display = 'block';
        window.scrollTo(0, 0);
    }

    function ocultarError() {
        const el = document.getElementById('wizard-error');
        if (el) el.style.display = 'none';
    }
</script>

<?= $this->endSection() ?>