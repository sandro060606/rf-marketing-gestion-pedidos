<!-- app/Views/plantillas/parciales/barra-lateral.php -->
<aside class="sidebar">

    <div class="sidebar-logo">
        <div class="marca">RF</div>
        <div class="subtitulo">Marketing S.A.C.</div>
    </div>

    <nav>
 <p class="nav-seccion">PRINCIPAL</p>
<a href="<?= site_url('admin/panel') ?>" class="nav-enlace <?= ($paginaActual == 'dashboard') ? 'activo' : '' ?>">
    <i class="bi bi-grid-1x2"></i> Dashboard
</a>

<p class="nav-seccion">EMPRESAS</p>

<div class="nav-item-dropdown">
    <div class="nav-enlace" id="btn-empresas-toggle" style="cursor:pointer;">
        <i class="bi bi-building"></i> 
        <span>Gestionar Empresas</span>
        <i class="bi bi-chevron-down ms-auto arrow-icon"></i>
    </div>

    <div class="nav-sub-menu <?= (strpos($paginaActual, 'empresa') !== false) ? 'show' : '' ?>" id="menu-empresas">
 <a href="<?= site_url('admin/empresas') ?>" class="nav-enlace sub-enlace <?= ($paginaActual == 'todas_empresas') ? 'activo' : '' ?>">
    <i  style="font-size: 10px;"></i> Todas las Empresas
</a>

        <?php foreach ($empresas as $emp): ?>
           <a href="<?= site_url('admin/kanban/'.$emp['id'].'/1') ?>" class="nav-enlace sub-enlace">
                <i class="bi bi-circle-fill nav-punto"></i>
                <span class="text-truncate"><?= $emp['nombreempresa'] ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<p class="nav-seccion">GESTIÓN</p>
<a href="<?= site_url('admin/usuarios') ?>" class="nav-enlace <?= ($paginaActual == 'usuarios') ? 'activo' : '' ?>">
    <i class="bi bi-people"></i> Usuarios
</a>
<a href="<?= site_url('admin/areas') ?>" class="nav-enlace <?= ($paginaActual == 'areas') ? 'activo' : '' ?>">
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