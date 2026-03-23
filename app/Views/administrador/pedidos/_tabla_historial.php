<?php $label = $tipo === 'cancelados' ? 'cancelados' : 'completados'; ?>
<div class="kb-hist-toolbar">
    <input class="kb-hist-search" placeholder="Buscar..." oninput="filtrarTabla(this)">
    <span class="kb-hist-total"><?= count($filas) ?> <?= $label ?></span>
</div>
<table class="kb-hist-table">
    <thead>
        <tr>
            <th>Pedido</th>
            <th>Tipo</th>
            <th>Área</th>
            <th>Empleado</th>
            <th>Creado</th>
            <th><?= $tipo === 'cancelados' ? 'Cancelado' : 'Completado' ?></th>
            <th>Detalle</th>
        </tr>
    </thead>
    <tbody class="hist-tbody">
        <?php if (empty($filas)) : ?>
            <tr><td colspan="7" class="kb-empty">Sin registros</td></tr>
        <?php else : ?>
            <?php foreach ($filas as $h) : ?>
            <tr>
                <td class="kb-hist-titulo"><?= esc($h['titulo'] ?? '—') ?></td>
                <td><?= esc($h['servicio']) ?></td>
                <td><?= esc($h['area_nombre']) ?></td>
                <td><?= $h['empleado'] ? esc($h['empleado'].' '.$h['empleado_ap']) : '—' ?></td>
                <td><?= $h['fechacreacion'] ? date('d M Y', strtotime($h['fechacreacion'])) : '—' ?></td>
                <td class="<?= $tipo === 'cancelados' ? 'kb-hist-rojo' : 'kb-hist-verde' ?>">
                    <?php
                        $fecha = $tipo === 'cancelados' ? ($h['fechacancelacion'] ?? null) : ($h['fechacompletado'] ?? null);
                        echo $fecha ? date('d M Y', strtotime($fecha)) : '—';
                    ?>
                </td>
                <td><button class="kb-btn-ver" onclick="window.location.href='<?= site_url('admin/pedidos/'.$h['id']) ?>'">Ver detalle</button></td>
            </tr>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>

<script>
function filtrarTabla(input) {
    const q = input.value.toLowerCase();
    input.closest('div').nextElementSibling.querySelectorAll('.hist-tbody tr').forEach(tr => {
        tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}
</script>