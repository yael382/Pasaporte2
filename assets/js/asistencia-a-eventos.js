document.addEventListener('DOMContentLoaded', () => {
    const inputScanner = document.getElementById('barcode_input');
    const eventoId = document.getElementById('evento_id').value;

    // Escuchar el Scanner
    inputScanner.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            procesarRegistro(inputScanner.value, 'scan');
            inputScanner.value = ''; // Limpiar para el siguiente
        }
    });

    // Función principal de envío
    async function procesarRegistro(valor, accion, forzarInscripcion = false) {
        const formData = new FormData();
        formData.append('evento_id', eventoId);
        formData.append('input_usuario', valor);
        formData.append('accion', accion);
        if(forzarInscripcion) formData.append('forzar', true);

        const resp = await fetch('asistencia_a_evento/AsistenciaController.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await resp.json();

        if (data.status === 'confirm') {
            if (confirm(data.message)) {
                // Si el admin acepta, registramos forzosamente
                registrarManual(data.usuario_id);
            }
        } else {
            alert(data.message);
            // Aquí podrías actualizar la UI (cambiar color de fila en la lista)
        }
    }
});
