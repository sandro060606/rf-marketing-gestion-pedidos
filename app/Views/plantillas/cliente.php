<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RF Marketing — <?= $titulo ?? 'Mi Panel' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600&family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('recursos/styles/base/variables.css') ?>">
    <link rel="stylesheet" href="<?= base_url('recursos/styles/plantilla/cliente.css') ?>">
    <?= $css_extra ?? '' ?>
</head>
<body>
<!-- Vista Latera (SideBar) -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <span class="brand-logo">RF</span>
        <span class="brand-text">Marketing</span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-group">
            <span class="nav-label">MI CUENTA</span>
            <a href="<?= base_url('cliente/mis-pedidos') ?>" class="nav-item <?= str_contains(uri_string(), 'mis-pedidos') ? 'active' : '' ?>">
                <i class="bi bi-bag-fill"></i> Mis Pedidos
            </a>
            <a href="<?= base_url('cliente/nuevo-pedido') ?>" class="nav-item <?= str_contains(uri_string(), 'nuevo-pedido') ? 'active' : '' ?>">
                <i class="bi bi-plus-circle-fill"></i> Nuevo Pedido
            </a>
            <a href="<?= base_url('cliente/notificaciones') ?>" class="nav-item <?= str_contains(uri_string(), 'notificaciones') ? 'active' : '' ?>">
                <i class="bi bi-bell-fill"></i> Notificaciones
            </a>
        </div>
    </nav>
    <div class="sidebar-footer">
        <small>RF MARKETING SAC</small>
        <small>v1.0</small>
    </div>
</aside>
<!-- Contenido Principal -->
<div class="main-wrapper">
    <header class="topbar">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <h5 class="topbar-title"><?= strtoupper($titulo ?? 'Mi Panel') ?></h5>
        <div class="topbar-actions">
            <a href="<?= base_url('cliente/notificaciones') ?>" class="topbar-icon" title="Notificaciones">
                <i class="bi bi-bell-fill"></i>
            </a>
            <div class="topbar-user">
                <div class="user-avatar">
                    <?= strtoupper(substr(session()->get('nombre') ?? 'C', 0, 1)) ?>
                </div>
                <div class="user-info d-none d-md-block">
                    <span class="user-name"><?= session()->get('nombre') ?></span>
                    <span class="user-role">Cliente</span>
                </div>
                <a href="<?= base_url('logout') ?>" class="topbar-icon ms-2" title="Cerrar sesión">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>
    </header>
    <main class="page-content">
        <?= $this->renderSection('contenido') ?>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle').addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('sidebar-open');
    });
</script>
<?= $js_extra ?? '' ?>
</body>
</html>