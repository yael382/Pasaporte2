<?php
$object->get(getvar('pk'));
?>

<h2 class="text-secondary">
    <i class="fa-solid fa-pen-to-square me-2"></i>Editar Evento:
    <span class="fw-normal"><?= htmlspecialchars($object->nombre ?? '') ?></span>
</h2>

<div class="card">
    <div class="card-body">
        <form method="post" action="eventos.php?accion=actualizar" id="main-form" autocomplete="off">
            <input type="hidden" name="accion" value="actualizar" />
            <input type="hidden" name="pk"     value="<?= htmlspecialchars($object->pk ?? '') ?>" />
            <?php $accion = 'actualizar'; include 'mainform.php'; ?>
            <hr />
            <button type="submit" class="btn btn-secondary">
                <i class="fa-regular fa-floppy-disk"></i> Guardar cambios
            </button>
            <a href="eventos.php?accion=mostrar&pk=<?= urlencode($object->pk ?? '') ?>" class="btn btn-outline-secondary ms-1">
                <i class="fa-regular fa-circle-xmark"></i> Cancelar
            </a>
        </form>
    </div>
</div>
