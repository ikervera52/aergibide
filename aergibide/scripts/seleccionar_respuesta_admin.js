function seleccionarRespuesta(boton, id, pregunta_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se podrá deshacer",
        showCancelButton: true,
        confirmColor: '#dc3545',
        cancelColor: '#6c757d',
        confirmButtonText: 'Sí,  seleccionar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            
            const exito = await fetchSeleccionarRespuesta(id, pregunta_id);

            if (exito) {

                Swal.fire(
                    '¡Seleccionada!',
                    'La respuesta ha sido seleccionada correctamente.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed || result.isDismissed) {
                        window.location.reload();
                    }
                });
                
            } else {
                Swal.fire(
                    '¡Error!',
                    'No se pudo seleccionar la respuesta. Inténtalo de nuevo.',
                    'error'
                );
            }
        }
    });
}

async function fetchSeleccionarRespuesta(id, pregunta_id) {
    try {

        rutaLimpia = 'index.php' + window.location.search;
        const respuesta = await fetch('index.php?controller=RespuestaController&accion=markSeleccionada&id=' + id + "&pregunta_id=" + pregunta_id);

        if (!respuesta.ok) {
            return false;
        }

        const datos = await respuesta.json();
        return datos.success;

    } catch (error) {
        console.error('Error de red o JSON:', error);
        return false;
    }
}