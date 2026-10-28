const btnNotificaciones = document.querySelector('#btnNotificaciones');
const panelNotificaciones = document.querySelector('#panelNotificaciones');
const capaNotificaciones = document.querySelector('#capaNotificaciones');

btnNotificaciones.addEventListener('click', abrirPanel);
capaNotificaciones.addEventListener('click', cerrarPanel);

async function abrirPanel(evento) {
    evento.preventDefault();

    if (panelNotificaciones.hidden == false) {
        cerrarPanel();
        return;
    }

    const respuesta = await fetch('index.php?controller=NotificacionController&accion=listar');
    const html = await respuesta.text();

    panelNotificaciones.innerHTML = html;
    panelNotificaciones.hidden = false;
    capaNotificaciones.hidden = false;
}

function cerrarPanel() {
    panelNotificaciones.hidden = true;
    capaNotificaciones.hidden = true;
}

async function eliminarNotificacion(id) {
    const respuesta = await fetch('index.php?controller=NotificacionController&accion=eliminar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id })
    });

    const resultado = await respuesta.json();

    if (resultado.ok == true) {
        document.querySelector('#notificacion-' + id).remove();
    }
}

