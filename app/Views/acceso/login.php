<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RF Marketing — Sistema de Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('recursos/styles/paginas/login.css') ?>">
</head>
<body>

<div class="bg-abstract">
    <div class="orb-glow"></div>
</div>

<main class="login-wrapper">
    <div class="login-card">
        <div class="row g-0 h-100">
            <div class="col-md-5 d-none d-md-flex side-branding">
                <div class="branding-content">
                    <div class="mini-badge">SISTEMA OFICIAL</div>
                    <h1 class="display-1 logo-text">RF</h1>
                    <div class="branding-footer">
                        <p class="mb-0 fw-bold">Gestión de Pedidos</p>
                        <small class="opacity-50">Solución Corporativa v1.0</small>
                    </div>
                </div>
            </div>

            <div class="col-md-7 side-form">
                <div class="form-wrapper">
                    <header class="mb-5">
                        <h2 class="fw-800 mb-1">BIENVENIDO</h2>
                       <p class="text-white-50 small">Por favor, introduce tus credenciales.</p>
                    </header>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger-custom mb-4">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('login') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="usr" name="usuario" placeholder="Usuario" required>
                            <label for="usr">USUARIO</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="pwd" name="clave" placeholder="Contraseña" required>
                            <label for="pwd">CONTRASEÑA</label>
                        </div>

                        <button type="submit" class="btn btn-rf-primary w-100 py-3 fw-bold">
                            ACCEDER AL PANEL
                        </button>
                    </form>

                    <footer class="mt-5 pt-4 border-top border-dark">
                        <div class="d-flex justify-content-between align-items-center opacity-50 small">
                            <span>RF MARKETING SAC</span>
                            <span>2026</span>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>