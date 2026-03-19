<?= $this->extend('plantillas/principal') ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('recursos/styles/paginas/panel.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<div class="sec-hd">USUARIOS DEL SISTEMA</div>

<div class="twrap">
  <div class="ttoolbar">
    <input class="tsearch" placeholder="Buscar usuario..." oninput="filtrarTabla(this,'tbody-usuarios')">
    <button class="btn-add" onclick="window.location.href='<?= site_url('admin/usuarios/crear') ?>'">
      + NUEVO USUARIO
    </button>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Usuario</th>
        <th>Rol</th>
        <th>Área / Empresa</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody id="tbody-usuarios">
      <?php foreach ($usuarios as $u) : ?>
        <tr>
          <td class="td-main"><?= esc($u['nombre'] . ' ' . $u['apellidos']) ?></td>
          <td><?= esc($u['usuario']) ?></td>
          <td>
            <span class="pill <?= $u['rol'] === 'administrador' ? 'p-admin' : ($u['rol'] === 'responsable' ? 'p-resp' : 'p-cli') ?>">
              <?= ucfirst($u['rol']) ?>
            </span>
          </td>
          <td><?= esc($u['area'] ?: '—') ?></td>
          <td>
            <span class="pill <?= $u['estado'] ? 'p-done' : 'p-cancel' ?>">
              <?= $u['estado'] ? 'Activo' : 'Inactivo' ?>
            </span>
          </td>
          <td style="white-space:nowrap">
            <button class="btn-sm" onclick="window.location.href='<?= base_url('admin/usuarios/editar/'.$u['id']) ?>'">Editar</button>
            <?php if ($u['rol'] !== 'administrador') : ?>
              <button class="btn-sm" style="margin-left:8px;border-color:#ef4444;color:#ef4444">Deshabilitar</button>
            <?php endif ?>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>