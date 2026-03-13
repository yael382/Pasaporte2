<?php

$object->get(getvar('pk'));
?>

<h2 class="text-secondary">
    <i class="fa-solid fa-calendar-days me-2"></i>
    <?= htmlspecialchars($object->nombre ?? 'Evento') ?>
</h2>

<div class="clearfix mb-3">
    <div class="btn-group float-end" role="group">
        <a class="btn btn-outline-secondary" href="eventos.php?accion=actualizar&pk=<?= urlencode($object->pk) ?>">
            <i class="fa-solid fa-pen-to-square"></i> Editar
        </a>
        <a class="btn btn-outline-danger"
           href="eventos.php?accion=eliminar&pk=<?= urlencode($object->pk) ?>"
           onclick="return confirm('¿Eliminar el evento «<?= addslashes(htmlspecialchars($object->nombre ?? '')) ?>»?')">
            <i class="fa-regular fa-trash-can"></i> Eliminar
        </a>
        <a class="btn btn-outline-secondary" href="eventos.php">
            <i class="fa-solid fa-list-ul"></i> Ver todos
        </a>
        <a class="btn btn-outline-secondary" href="eventos.php?accion=crear">
            <i class="fa-solid fa-plus"></i> Nuevo
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <fieldset>
            
            <?php $accion = 'mostrar'; include 'mainform.php'; ?>
        </fieldset>
    </div>
</div>
