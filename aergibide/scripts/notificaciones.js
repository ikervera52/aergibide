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

    if (resultado.ok) {
        document.querySelector('#notificacion-' + id).remove();

        const quedan = document.querySelectorAll('#panelNotificaciones [id^="notificacion-"]').length;
        const icono = document.querySelector('#btnNotificaciones i');
        if (quedan === 0) {
            icono.classList.remove('bi-bell-fill');
            icono.classList.add('bi-bell');
        }
    }
}

async function actualizarIconoCampana() {
    try {
        const res = await fetch('index.php?controller=NotificacionController&accion=estado');
        const { hay } = await res.json();
        const icono = document.querySelector('#btnNotificaciones i');
        icono.classList.toggle('bi-bell-fill', hay);
        icono.classList.toggle('bi-bell', !hay);
    } catch (e) {
        console.error('No se pudo actualizar el icono', e);
    }
}

