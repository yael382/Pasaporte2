<?php

$accion = getvar('accion') ?? 'listar';
$method = $_SERVER['REQUEST_METHOD'];
$object = new Evento();
$errors = [];

if ($method === 'POST' && $accion === 'crear') {
    $_POST['requiere_registro'] = isset($_POST['requiere_registro']) ? 1 : 0;
    $object->fromArray($_POST);
    try {
        $object->save();
        header('Location: eventos.php?accion=mostrar&pk=' . urlencode($object->pk) . '&ok=creado');
        exit;
    } catch (Exception $e) {
        error_log("Error saving event: " . $e->getMessage());
        $errors[] = "Error al guardar el evento: " . $e->getMessage();
    }

} elseif ($method === 'POST' && $accion === 'actualizar') {
    $_POST['requiere_registro'] = isset($_POST['requiere_registro']) ? 1 : 0;
    $object->fromArray($_POST);
    $object->pk = isset($_POST['pk']) && $_POST['pk'] !== '' ? $_POST['pk'] : getvar('pk');
    try {
        $object->save();
        header('Location: eventos.php?accion=mostrar&pk=' . urlencode($object->pk) . '&ok=actualizado');
        exit;
    } catch (Exception $e) {
        error_log("Error saving event: " . $e->getMessage());
        $errors[] = "Error al actualizar el evento: " . $e->getMessage();
    }

} elseif ($accion === 'eliminar') {
    $object->pk = getvar('pk');
    try {
        $object->delete();
        header('Location: eventos.php?ok=eliminado');
        exit;
    } catch (Exception $e) {
        error_log("Error deleting event: " . $e->getMessage());
        $errors[] = "Error al eliminar el evento: " . $e->getMessage();
        $accion = 'listar';
    }
}
