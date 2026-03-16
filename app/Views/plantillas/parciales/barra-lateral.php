<!-- app/Views/plantillas/parciales/barra-lateral.php -->
<aside class="sidebar">

    <div class="sidebar-logo">
        <div class="marca">RF</div>
        <div class="subtitulo">Marketing S.A.C.</div>
    </div>

    <nav>
        <p class="nav-seccion">Principal</p>
        <a href="<?= site_url('admin/dashboard') ?>" class="nav-enlace <?= ($paginaActual ?? '') === 'dashboard' ? 'activo' : '' ?>">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>

        <p class="nav-seccion">Empresas</p>
        <a href="<?= site_url('admin/empresas') ?>" class="nav-enlace <?= ($paginaActual ?? '') === 'empresas' ? 'activo' : '' ?>">
            <i class="bi bi-building"></i> Empresas
        </a>

        <p class="nav-seccion">Gestión</p>
        <a href="<?= site_url('admin/usuarios') ?>" class="nav-enlace <?= ($paginaActual ?? '') === 'usuarios' ? 'activo' : '' ?>">
            <i class="bi bi-people"></i> Usuarios
        </a>
        <a href="<?= site_url('admin/areas') ?>" class="nav-enlace <?= ($paginaActual ?? '') === 'areas' ? 'activo' : '' ?>">
            <i class="bi bi-diagram-3"></i> Áreas
        </a>
    </nav>

    <div class="sidebar-usuario">
        <div class="usuario-avatar">AD</div>
        <div>
            <div class="usuario-nombre">Administrador</div>
            <div class="usuario-rol">Admin</div>
        </div>
        <a href="<?= site_url('logout') ?>" class="ms-auto" style="color:#444" title="Salir">
            <i class="bi bi-box-arrow-right"></i>
        </a>
    </div>

</aside>