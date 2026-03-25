<?php
$eventos = $object->getTodosEventos();
?>
<div class="card shadow-sm custom-border mb-4">
    <div class="card-body text-center p-md-5">
        <h3 class="mb-4"><i class="fa-solid fa-qrcode"></i> Lector de Gafetes</h3>

        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <div class="form-floating">
                    <select id="evento_id_qr" class="form-select" required>
                        <option value="">Seleccione un evento primero...</option>
                        <?php foreach($eventos as $e): ?>
                            <option value="<?= htmlspecialchars($e['id']) ?>">
                                <?= htmlspecialchars($e['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="evento_id_qr">Selecciona el evento para escanear</label>
                </div>
            </div>
        </div>

        <button class="btn btn-primary btn-lg mb-3 shadow" id="btn-iniciar-qr" onclick="iniciarEscaneoAsistenciaEmbed()">
            <i class="fa-solid fa-camera"></i> Iniciar Escáner
        </button>
        <button class="btn btn-outline-danger btn-lg mb-3 shadow d-none" id="btn-detener-qr" onclick="detenerEscaneoAsistenciaEmbed()">
            <i class="fa-solid fa-stop"></i> Detener Cámara
        </button>

        <div id="qr-reader-container" class="mx-auto mt-3 bg-dark" style="width: 100%; max-width: 450px; display: none; border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--tw-shadow);">
            <div id="qr-reader" style="width: 100%;"></div>
        </div>

        <div id="qr-status" class="mt-4 fs-5 mx-auto" style="max-width: 500px; min-height: 60px;"></div>
    </div>
</div>
