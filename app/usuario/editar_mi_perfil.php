<h2 class="text-secondary">
    <i class="fa-regular fa-id-card"></i>
    Mi Perfil
</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="post" action="mi_perfil.php?accion=update" id="main-form" autocomplete="off">
            <?php include 'form_mi_perfil.php'; ?>
            <input type="hidden" name="accion" value="update" />
            <div class="mt-3">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fa-regular fa-floppy-disk"></i>
                    Guardar cambios
                </button>
                <a href="index.php" class="btn btn-outline-secondary ms-2">
                    <i class="fa-regular fa-circle-xmark"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
