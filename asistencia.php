<?php
include_once "app/usuario/model.php";
session_start();

include_once 'helpers/db.php';
include_once 'helpers/vars.php';
include_once 'app/asistencia/modelo_asistencia.php';
include_once 'app/evento/model.php';

// Verificación de permisos para acceder al módulo de asistencia
if (!isset($_SESSION["current_user"]) || (!$_SESSION["current_user"]->can("asistencia.view_asistencia") && !$_SESSION["current_user"]->can("asistencia.asistencia.*"))) {
    header("Location: index.php");
    exit();
}

$accion = getvar('accion');
$object = new Asistencia();
$errors = [];
$mensaje = getvar('mensaje');

// Lógica de Procesamiento (Controlador integrado)
if ($accion === 'marcar' && ($_SESSION["current_user"]->can("asistencia.add_asistencia") || $_SESSION["current_user"]->can("asistencia.asistencia.*"))) {
    try {
        $evento_id = getvar('evento_id');
        $usuario_input = trim(getvar('usuario_id')); // Acepta Matrícula o ID

        $userModel = new Usuario();
        $usuario_row = $userModel->select("id = ? OR matricula = ?", [$usuario_input, $usuario_input]);

        if (!$usuario_row) {
            $errors[] = "Usuario no encontrado con ID o Matrícula: " . htmlspecialchars($usuario_input);
            $accion = 'listar';
        } else {
            $res = $object->autoRegistrarYAsistir($evento_id, $usuario_row['id'], $_SESSION["current_user"]->id);
            if ($res) {
                header('Location: asistencia.php?accion=listar&mensaje=' . urlencode('Asistencia registrada con éxito.'));
                exit;
            } else {
                $errors[] = "El usuario ya tiene asistencia marcada para este evento.";
                $accion = 'listar';
            }
        }
    } catch (Exception $e) {
        $errors[] = "Error al registrar asistencia: " . $e->getMessage();
        $accion = 'listar';
    }
} elseif ($accion === 'autoregistrar' && ($_SESSION["current_user"]->can("asistencia.add_asistencia") || $_SESSION["current_user"]->can("asistencia.asistencia.*"))) {
    try {
        $evento_id = getvar('evento_id');
        $usuario_id = getvar('usuario_id');

        $res = $object->autoRegistrarYAsistir($evento_id, $usuario_id, $_SESSION["current_user"]->id);

        if ($res) {
            header('Location: asistencia.php?accion=listar&mensaje=' . urlencode('Usuario registrado al evento y asistencia marcada.'));
            exit;
        }
    } catch (Exception $e) {
        $errors[] = "Error en el auto-registro: " . $e->getMessage();
        $accion = 'listar';
    }
} elseif ($accion === 'eliminar' && ($_SESSION["current_user"]->can("asistencia.delete_asistencia") || $_SESSION["current_user"]->can("asistencia.asistencia.*"))) {
    try {
        $evento_id = getvar('evento_id');
        $usuario_id = getvar('usuario_id');

        $object->eliminarAsistencia($evento_id, $usuario_id);
        header('Location: asistencia.php?accion=listar&mensaje=' . urlencode('Registro de asistencia eliminado.'));
        exit;
    } catch (Exception $e) {
        $errors[] = "Error al eliminar asistencia: " . $e->getMessage();
        $accion = 'listar';
    }
}

?><!DOCTYPE html>
<html lang="es-MX">

<head>
    <?php include 'templates/head.php'; ?>
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>

<body>
    <?php include 'templates/header.php'; ?>

    <main class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
            <h1 class="m-0 text-center text-md-start"><i class="fa-solid fa-clipboard-user"></i> Asistencia</h1>
            <?php if ($_SESSION["current_user"]->can("asistencia.add_asistencia") || $_SESSION["current_user"]->can("asistencia.asistencia.*")): ?>
                <div class="btn-group shadow-sm w-100 w-md-auto" role="group">
                    <a href="asistencia.php?accion=listar" class="btn <?= ($accion === 'listar' || $accion === null) ? 'btn-primary' : 'btn-outline-secondary' ?>"><i class="fa-solid fa-clock-rotate-left"></i> Historial</a>
                    <a href="asistencia.php?accion=escanear" class="btn <?= ($accion === 'escanear') ? 'btn-primary' : 'btn-outline-secondary' ?>"><i class="fa-solid fa-qrcode"></i> QR</a>
                    <a href="asistencia.php?accion=manual" class="btn <?= ($accion === 'manual') ? 'btn-primary' : 'btn-outline-secondary' ?>"><i class="fa-solid fa-keyboard"></i> Manual</a>
                </div>
            <?php endif; ?>
        </div>

        <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endforeach; ?>

        <?php if ($mensaje): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($mensaje); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php
        // Carga de sub-vistas según la acción
        if ($accion === 'escanear') {
            include 'app/asistencia/escanear.php';
        } elseif ($accion === 'manual') {
            include 'app/asistencia/manual.php';
        } elseif ($accion === 'listar' || $accion === null) {
            include 'app/asistencia/listar.php';
        } elseif ($accion === 'mostrar') {
            include 'app/asistencia/mostrar.php';
        }
        ?>
    </main>

    <?php include 'templates/footer.php'; ?>
    <script src="assets/js/asistencia.js"></script>
</body>
</html>
