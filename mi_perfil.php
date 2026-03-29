<?php
include_once __DIR__ . "/init.php";

startAPI("otro.update_perfil");

$accion = getvar('accion');
$errors = [];

if ($accion === 'update') {
    $camposPermitidos = ['nombre', 'apaterno', 'amaterno', 'categoria', 'grupo', 'email', 'whatsapp'];

    $object = new Usuario();
    $object->get($_SESSION["current_user"]->pk);

    $datosActualizar = [];
    foreach ($camposPermitidos as $campo) {
        if (isset($_POST[$campo])) {
            $datosActualizar[$campo] = $_POST[$campo];
        }
    }
    $object->fromArray($datosActualizar);

    try {
        $object->save();

        $object->logout();
        header('Location: index.php?updated=1');
        exit();
    } catch (Exception $e) {
        error_log("Error actualizando perfil propio: " . $e->getMessage());
        $errors[] = "Error al guardar los cambios: " . $e->getMessage();
    }
}
?><!DOCTYPE html>
<html lang="es-MX">
<head>
    <?php include 'templates/head.php'; ?>
</head>
<body>
    <?php include 'templates/header.php'; ?>

    <main class="container">
        <h1>Mi Perfil</h1>

        <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endforeach; ?>

        <?php include 'app/usuario/editar_mi_perfil.php'; ?>
    </main>

    <?php include 'templates/footer.php'; ?>
</body>
</html>
