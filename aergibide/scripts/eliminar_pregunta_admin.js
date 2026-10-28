function eliminarPregunta(boton, id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se podrá deshacer",
        showCancelButton: true,
        confirmColor: '#dc3545',
        cancelColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            
            const exito = await fetchEliminarPregunta(id);

            if (exito) {

                Swal.fire(
                    '¡Eliminado!',
                    'La pregunta ha sido borrada correctamente.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed || result.isDismissed) {
                        window.location.reload();
                    }
                });
                
            } else {
                Swal.fire(
                    '¡Error!',
                    'No se pudo eliminar la pregunta. Inténtalo de nuevo.',
                    'error'
                );
            }
        }
    });
}

async function fetchEliminarPregunta(id) {
    try {

        rutaLimpia = 'index.php' + window.location.search;
        const respuesta = await fetch('index.php?accion=destroy&id=' + id);

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