<?php
$eventos = $object->getTodosEventos();
?>
<div class="card mb-4 custom-border shadow-sm">
    <div class="card-body p-md-5">
        <h3 class="mb-4 text-center"><i class="fa-solid fa-keyboard"></i> Registro Manual</h3>
        <form method="post" action="asistencia.php">
            <input type="hidden" name="accion" value="marcar" />
            <div class="row g-3 justify-content-center">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select name="evento_id" id="evento_id_manual" class="form-select" required>
                            <option value="">Seleccione un evento...</option>
                            <?php foreach($eventos as $e): ?>
                                <option value="<?= htmlspecialchars($e['id']) ?>">
                                    <?= htmlspecialchars($e['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="evento_id_manual">Evento Activo</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="text" name="usuario_id" id="usuario_id" class="form-control" required placeholder="Ingresar matrícula o ID">
                        <label for="usuario_id">ID o Matrícula del Usuario</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-3 fs-5 shadow">
                        <i class="fa-solid fa-check-to-slot"></i> Registrar Asistencia
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
