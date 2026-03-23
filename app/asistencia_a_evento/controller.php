<?php
require_once 'model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model = new Asistencia();
    $eventoId = $_POST['evento_id'];
    $input = $_POST['input_usuario']; // Puede ser ID de lista o Código de Barras

    // Lógica para Scanner
    if ($_POST['accion'] === 'scan') {
        $usuario = $model->buscarPorCodigo($input);
        
        if (!$usuario) {
            echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
            exit;
        }

        $inscrito = $model->verificarInscripcion($eventoId, $usuario['id']);
        
        if (!$inscrito) {
            echo json_encode([
                'status' => 'confirm', 
                'message' => 'Usuario no inscrito. ¿Desea inscribirlo y registrar asistencia?',
                'usuario_id' => $usuario['id']
            ]);
        } else {
            $model->registrarAsistencia($eventoId, $usuario['id'], 'scanner', true);
            echo json_encode(['status' => 'success', 'message' => 'Asistencia registrada']);
        }
    }
}
