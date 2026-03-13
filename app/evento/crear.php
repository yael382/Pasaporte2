<?php
?>

<h2 class="text-secondary">
    <i class="fa-solid fa-calendar-plus me-2"></i>Nuevo Evento
</h2>

<div class="card">
    <div class="card-body">
        <form method="post" action="eventos.php?accion=crear" id="main-form" autocomplete="off">
            <input type="hidden" name="accion" value="crear" />
            <?php include 'mainform.php'; ?>
            <hr />
            <button type="submit" class="btn btn-secondary">
                <i class="fa-regular fa-floppy-disk"></i> Guardar
            </button>
            <a href="eventos.php" class="btn btn-outline-secondary ms-1">
                <i class="fa-regular fa-circle-xmark"></i> Cancelar
            </a>
        </form>
    </div>
</div>
