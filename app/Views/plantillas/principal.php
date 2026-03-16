<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title>RF Marketing — <?= esc($titulo ?? 'Admin') ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
 <link href="<?= base_url('recursos/styles/plantilla/barra-lateral.css') ?>" rel="stylesheet">
<link href="<?= base_url('recursos/styles/plantilla/barra-superior.css') ?>" rel="stylesheet">
    <?= $this->renderSection('styles') ?>
</head>
<body>

    <?= $this->include('plantillas/parciales/barra-lateral') ?>

    <div class="contenedor-principal">
        <?= $this->include('plantillas/parciales/barra-superior') ?>
        <main class="contenido">
            <?= $this->renderSection('contenido') ?>
        </main>
    </div>

    <!-- Modal genérico (se usa desde JS) -->
    <div class="modal fade" id="modal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-titulo"></h6>
                    <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modal-cuerpo"></div>
                <div class="modal-footer gap-2" id="modal-pie"></div>
            </div>
        </div>
    </div>

    <div id="toast"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
     <script src="<?= base_url('scripts/nucleo/app.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>

</body>
</html>