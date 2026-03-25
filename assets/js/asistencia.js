let html5QrCode = null;

function iniciarEscaneoAsistenciaEmbed() {
    const eventoSelect = document.getElementById('evento_id_qr');
    if (!eventoSelect || !eventoSelect.value) {
        alert("Por favor, selecciona un evento primero para saber a qué evento pasar lista.");
        if (eventoSelect) eventoSelect.focus();
        return;
    }

    const evento_id = eventoSelect.value;

    document.getElementById('btn-iniciar-qr').classList.add('d-none');
    document.getElementById('btn-detener-qr').classList.remove('d-none');

    const qrContainer = document.getElementById('qr-reader-container');
    qrContainer.style.display = 'block';

    document.getElementById('qr-status').innerHTML = '';

    html5QrCode = new Html5Qrcode("qr-reader");

    const qrCodeSuccessCallback = (decodedText, decodedResult) => {
        html5QrCode.pause();

        const statusDiv = document.getElementById('qr-status');
        statusDiv.innerHTML = `<div class="alert alert-info mb-0"><i class="fa-solid fa-spinner fa-spin"></i> Consultando...</div>`;

        const formData = new FormData();
        formData.append('accion', 'procesar_qr');
        formData.append('evento_id', evento_id);
        formData.append('matricula', decodedText);

        fetch('app/asistencia/controlador_asistencia.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(text => {
            let data;
            try {
                data = JSON.parse(text);
            } catch (err) {
                console.error("La respuesta no es JSON válido:", text);
                throw new Error("Error interno del servidor. Revisa la consola para más detalles.");
            }

            if (data.status === 'success') {
                statusDiv.innerHTML = `<div class="alert alert-success mb-0 fw-bold"><i class="fa-solid fa-circle-check"></i> ${data.message}</div>`;
                setTimeout(() => { statusDiv.innerHTML = ''; html5QrCode.resume(); }, 2000);
            } else if (data.status === 'not_registered') {
                statusDiv.innerHTML = `<div class="alert alert-warning mb-0 fw-bold"><i class="fa-solid fa-triangle-exclamation"></i> Requiere confirmación en pantalla...</div>`;
                if (confirm(`${data.nombre} no está inscrito en este evento.\n¿Deseas auto-inscribirlo y tomar su asistencia ahora mismo?`)) {
                    const autoData = new FormData();
                    autoData.append('accion', 'confirmar_auto');
                    autoData.append('evento_id', evento_id);
                    autoData.append('usuario_id', data.usuario_id);

                    fetch('app/asistencia/controlador_asistencia.php', { method: 'POST', body: autoData })
                    .then(res => res.text())
                    .then(autoText => {
                        let autoRes;
                        try {
                            autoRes = JSON.parse(autoText);
                        } catch (err) {
                            console.error("La respuesta auto-registro no es JSON:", autoText);
                            throw new Error("Error del servidor en auto-registro.");
                        }

                        if (autoRes.status === 'success') {
                            statusDiv.innerHTML = `<div class="alert alert-success mb-0 fw-bold"><i class="fa-solid fa-circle-check"></i> Inscrito y asistencia tomada.</div>`;
                            setTimeout(() => { statusDiv.innerHTML = ''; html5QrCode.resume(); }, 2000);
                        } else {
                            statusDiv.innerHTML = `<div class="alert alert-danger mb-0 fw-bold"><i class="fa-solid fa-circle-xmark"></i> ${autoRes.message}</div>`;
                            setTimeout(() => { statusDiv.innerHTML = ''; html5QrCode.resume(); }, 2500);
                        }
                    }).catch((e) => {
                        statusDiv.innerHTML = `<div class="alert alert-danger mb-0 fw-bold"><i class="fa-solid fa-circle-xmark"></i> ${e.message || "Error al conectar."}</div>`;
                        setTimeout(() => html5QrCode.resume(), 2500);
                    });
                } else {
                    statusDiv.innerHTML = `<div class="alert alert-secondary mb-0">Acción cancelada.</div>`;
                    setTimeout(() => { statusDiv.innerHTML = ''; html5QrCode.resume(); }, 1500);
                }
            } else {
                statusDiv.innerHTML = `<div class="alert alert-danger mb-0 fw-bold"><i class="fa-solid fa-circle-xmark"></i> ${data.message}</div>`;
                setTimeout(() => { statusDiv.innerHTML = ''; html5QrCode.resume(); }, 2500);
            }
        })
        .catch(err => {
            console.error(err);
            statusDiv.innerHTML = `<div class="alert alert-danger mb-0 fw-bold"><i class="fa-solid fa-triangle-exclamation"></i> ${err.message || 'Error de red.'}</div>`;
            setTimeout(() => { statusDiv.innerHTML = ''; html5QrCode.resume(); }, 2500);
        });
    };

    html5QrCode.start(
        { facingMode: "environment" }, { fps: 10, qrbox: { width: 250, height: 250 } }, qrCodeSuccessCallback
    ).catch(err => {
        alert("Error al iniciar la cámara: No se detectó o no hay permisos.");
        detenerEscaneoAsistenciaEmbed();
    });
}

function detenerEscaneoAsistenciaEmbed() {
    if (html5QrCode) {
        html5QrCode.stop().then(() => {
            html5QrCode.clear();
        }).catch(err => console.log("Error deteniendo cámara:", err));
    }
    document.getElementById('qr-reader-container').style.display = 'none';
    document.getElementById('btn-iniciar-qr').classList.remove('d-none');
    document.getElementById('btn-detener-qr').classList.add('d-none');
    document.getElementById('qr-status').innerHTML = '';
}
