<?php
$object->get(getvar('pk'));
?>
<h2 class="text-secondary"><?php echo htmlspecialchars($object ?? ''); ?></h2>

<div class="clearfix mb-3">
<div class="btn-group float-end" role="group" aria-label="Barra de Herramientas">
    <?php if(currentUserCan("usuario.change_usuario")): ?>
    <a title="Actualizar" class="btn btn-outline-secondary" href="usuarios.php?accion=actualizar&pk=<?= urlencode($object->pk) ?>">
        <i class="fa-solid fa-pen-to-square"></i>
        <!-- Actualizar -->
    </a>
    <?php endif; ?>
    <?php if(currentUserCan("usuario.delete_usuario")): ?>
    <a title="Eliminar" class="btn btn-outline-danger" href="usuarios.php?accion=eliminar&pk=<?= urlencode($object->pk) ?>"
        onclick="return confirm('¿Eliminar este usuario?')">
        <i class="fa-regular fa-trash-can"></i>
        <!-- Eliminar -->
    </a>
    <?php endif; ?>
    <?php if(currentUserCan("usuario.list_usuario")): ?>
    <a title="Ver todos" type="button" class="btn btn-outline-secondary" href="usuarios.php?accion=listar">
        <i class="fa-solid fa-list-ul"></i>
        <!-- Ver todos -->
    </a>
    <?php endif; ?>
    <?php if(currentUserCan("usuario.add_usuario")): ?>
    <a title="Nuevo" type="button" class="btn btn-outline-secondary" href="usuarios.php?accion=crear">
        <i class="fa-solid fa-plus"></i>
        <!-- Nuevo -->
    </a>
    <?php endif; ?>
</div>
</div>

<div class="card"><div class="card-body">
    <fieldset disabled="disabled">
    <?php include 'form_read.php'; ?>
    </fieldset>
</div></div>
