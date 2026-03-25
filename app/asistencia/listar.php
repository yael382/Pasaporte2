<?php
$filtro_evento   = intval(getvar('evento_id') ?? 0);
$filtro_grupo    = getvar('grupo') ?? '';
$filtro_busqueda = getvar('busqueda') ?? '';

$eventos = $object->getTodosEventos();
$grupos  = $object->getGrupos();
$asistencias = $object->listar($filtro_evento, $filtro_grupo, $filtro_busqueda);

$can_delete = $_SESSION["current_user"]->can(["asistencia.delete_asistencia", "asistencia.*"]);
$can_delete = $_SESSION["current_user"]->can("asistencia.delete_asistencia") || $_SESSION["current_user"]->can("asistencia.asistencia.*");
?>


<!-- Filtros de Asistencias -->
<div class="card mb-3 shadow-sm custom-border border-secondary">
    <div class="card-body pb-2">
        <h5 class="mb-3 text-primary"><i class="fa-solid fa-filter"></i> Filtrar Historial</h5>
        <form method="get" action="asistencia.php" class="row g-2 align-items-end">
            <input type="hidden" name="accion" value="listar" />

            <div class="col-md-4">
                <div class="form-floating">
                    <select name="evento_id" id="f_evento" class="form-select">
                        <option value="0">— Todos los eventos —</option>
                        <?php foreach ($eventos as $ev): ?>
                            <option value="<?= $ev['id'] ?>" <?= ($filtro_evento == $ev['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($ev['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="f_evento">Evento</label>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-floating">
                    <select name="grupo" id="f_grupo" class="form-select">
                        <option value="">— Todos —</option>
                        <?php foreach ($grupos as $g): ?>
                            <?php if(!empty($g['grupo'])): ?>
                            <option value="<?= htmlspecialchars($g['grupo']) ?>" <?= ($filtro_grupo === $g['grupo']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($g['grupo']) ?>
                            </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <label for="f_grupo">Grupo</label>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" name="busqueda" id="f_busqueda" class="form-control"
                           placeholder="Buscar..."
                           value="<?= htmlspecialchars($filtro_busqueda) ?>" />
                    <label for="f_busqueda">Matrícula / Nombre</label>
                </div>
            </div>

            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-primary w-100 h-100 py-3">
                    <i class="fa-solid fa-magnifying-glass"></i> Filtrar
                </button>
                <a href="asistencia.php" class="btn btn-outline-secondary w-100 h-100 py-3 d-flex align-items-center justify-content-center" title="Limpiar">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Historial de Asistencias -->
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="data-list" class="table table-hover table-striped table-sm mb-0 border-top">
                <thead class="table-dark">
                    <tr>
                        <th>Evento</th>
                        <th>Matrícula</th>
                        <th>Nombre</th>
                        <th>Grupo</th>
                        <th>Fecha de Entrada</th>
                        <th>Registrado por</th>
                        <?php if ($can_delete): ?>
                        <th class="text-center"><i class="fa-solid fa-gears"></i></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($asistencias as $asistencia): ?>
                        <tr>
                            <td><?= htmlspecialchars($asistencia['evento_nombre']) ?></td>
                            <td><?= htmlspecialchars($asistencia['matricula']) ?></td>
                            <td><?= htmlspecialchars(trim($asistencia['nombre'] . ' ' . $asistencia['apaterno'] . ' ' . $asistencia['amaterno'])) ?></td>
                            <td><?= htmlspecialchars($asistencia['grupo']) ?></td>
                            <td><?= htmlspecialchars($asistencia['fecha_entrada']) ?></td>
                            <td><?= htmlspecialchars($asistencia['admin_nombre']) ?></td>
                            <?php if ($can_delete): ?>
                            <td class="text-center text-nowrap">
                                <a class="btn btn-sm btn-outline-danger" href="asistencia.php?accion=eliminar&evento_id=<?= urlencode($asistencia['evento_id']) ?>&usuario_id=<?= urlencode($asistencia['usuario_id']) ?>" onclick="return confirm('¿Eliminar esta asistencia?')">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof jQuery !== 'undefined' && $.fn.DataTable) {
        if ($.fn.DataTable.isDataTable('#data-list')) {
            $('#data-list').DataTable().destroy();
        }
        $('#data-list').DataTable({
            "order": [[4, "desc"]] // Fecha de entrada descendente
        });
    }
});
</script>
