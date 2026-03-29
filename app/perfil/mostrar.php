<?php
$object->get(getvar('pk'));
?>
<h2 class="text-secondary"><?php echo htmlspecialchars($object ?? ''); ?></h2>

<div class="clearfix mb-3">
<div class="btn-group float-end" role="group" aria-label="Barra de Herramientas">
    <?php if(currentUserCan("perfil.change_perfil")): ?>
    <a title="Actualizar" class="btn btn-outline-secondary" href="perfiles.php?accion=actualizar&pk=<?= urlencode($object->pk) ?>">
        <i class="fa-solid fa-pen-to-square"></i>
        <!-- Actualizar -->
    </a>
    <?php endif; ?>
    <?php if(currentUserCan("perfil.delete_perfil")): ?>
    <a title="Eliminar" class="btn btn-outline-danger" href="perfiles.php?accion=eliminar&pk=<?= urlencode($object->pk) ?>"
        onclick="return confirm('¿Eliminar este perfil?')">
        <i class="fa-regular fa-trash-can"></i>
        <!-- Eliminar -->
    </a>
    <?php endif; ?>
    <?php if(currentUserCan("perfil.list_perfil")): ?>
    <a title="Ver todos" type="button" class="btn btn-outline-secondary" href="perfiles.php?accion=listar">
        <i class="fa-solid fa-list-ul"></i>
        <!-- Ver todos -->
    </a>
    <?php endif; ?>
    <?php if(currentUserCan("perfil.add_perfil")): ?>
    <a title="Nuevo" type="button" class="btn btn-outline-secondary" href="perfiles.php?accion=crear">
        <i class="fa-solid fa-plus"></i>
        <!-- Nuevo -->
    </a>
    <?php endif; ?>
</div>
</div>

<div class="card"><div class="card-body">
    <fieldset disabled="disabled">
    <?php include 'mainform.php'; ?>
    </fieldset>
</div></div>
