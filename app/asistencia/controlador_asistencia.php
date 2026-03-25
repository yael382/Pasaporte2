<?php
include_once __DIR__ . '/../../helpers/db.php';
include_once __DIR__ . '/../../helpers/vars.php';
include_once __DIR__ . '/modelo_asistencia.php';
include_once __DIR__ . '/../usuario/model.php';

session_start();
if (!isset($_SESSION["current_user"]) || (!$_SESSION["current_user"]->can("asistencia.add_asistencia") && !$_SESSION["current_user"]->can("asistencia.asistencia.*"))) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'No autorizado.']);
    exit;
}

if (!isset($_SESSION["current_user"]) || !$_SESSION["current_user"]->can(["asistencia.add_asistencia"])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'No autorizado.']);
    exit;
}
if (!isset($_SESSION["current_user"]) || !$_SESSION["current_user"]->can(["asistencia.*"])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'No autorizado.']);
    exit;
}

$accion = getvar('accion') ?? 'listar';
$method = $_SERVER['REQUEST_METHOD'];
$object = new Asistencia();
$errors = [];

// 1. PROCESAMIENTO DE ESCANEO (AJAX / POST)
if ($method === 'POST' && $accion === 'procesar_qr') {
    header('Content-Type: application/json');
    $evento_id = intval(getvar('evento_id'));
    $matricula = getvar('matricula');

    if ($evento_id <= 0 || empty($matricula)) {
        echo json_encode(['status' => 'error', 'message' => 'Faltan datos (Evento o Matrícula).']);
        exit;
    }

    try {
        $userModel = new Usuario();
        $usuario_row = null;

        // Tu QR devuelve "mat:12345" o "id:123", extraemos la cadena real.
        $matricula = trim($matricula);

        if (strpos($matricula, 'mat:') === 0) {
            $usuario_row = $userModel->select("matricula = ?", [trim(substr($matricula, 4))]);
        } elseif (strpos($matricula, 'id:') === 0) {
            $usuario_row = $userModel->select("id = ?", [trim(substr($matricula, 3))]);
        } else {
            // Búsqueda abierta: usar ID | Matrícula (OR)
            $usuario_row = $userModel->select("id = ? OR matricula = ?", [$matricula, $matricula]);
        }

        if (!$usuario_row) {
            echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado.']);
            exit;
        }

        // Instanciamos el objeto con el ID encontrado
        $usuario = new Usuario();
        $usuario->get($usuario_row['id']);

        // Armamos el nombre completo usando las variables
        $nombre_completo = trim($usuario->nombre . ' ' . $usuario->apaterno . ' ' . $usuario->amaterno);

        // Verificar si ya está en la tabla de 'registro'
        if ($object->verificarRegistro($evento_id, $usuario->id)) {
            // Caso A: Ya está registrado, intentamos marcar asistencia directo
            $asistio = $object->marcarAsistencia($evento_id, $usuario->id, $_SESSION["current_user"]->id);

            if ($asistio) {
                echo json_encode([
                    'status' => 'success',
                    'message' => "Asistencia marcada: {$nombre_completo}"
                ]);
            } else {
                echo json_encode([
                    'status' => 'error', // Mostrará recuadro rojo en JS para duplicados
                    'message' => "¡Cuidado! {$nombre_completo} ya tiene asistencia registrada."
                ]);
            }
        } else {
            // Caso B: No está registrado, pedir confirmación para auto-registro
            echo json_encode([
                'status' => 'not_registered',
                'usuario_id' => $usuario->id,
                'nombre' => $nombre_completo,
                'message' => "El usuario no está inscrito. ¿Deseas realizar el auto-registro?"
            ]);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;

// 2. AUTO-REGISTRO CONFIRMADO
} elseif ($method === 'POST' && $accion === 'confirmar_auto') {
    header('Content-Type: application/json');
    $evento_id = intval(getvar('evento_id'));
    $usuario_id = intval(getvar('usuario_id'));

    try {
        $asistio = $object->autoRegistrarYAsistir($evento_id, $usuario_id, $_SESSION["current_user"]->id);

        if ($asistio) {
            echo json_encode(['status' => 'success', 'message' => 'Usuario inscrito y asistencia tomada.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'El usuario ya tenía asistencia registrada en el evento.']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Fallo al auto-registrar.']);
    }
    exit;
}
