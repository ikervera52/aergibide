function toggleMenuAdmin(icono) {
    const contenedor = icono.closest('.acciones-admin-pregunta');
    const menu = contenedor.querySelector('.menu-desplegable-admin');
    
    document.querySelectorAll('.menu-desplegable-admin').forEach(m => {
        if (m !== menu) m.classList.add('oculto');
    });

    menu.classList.toggle('oculto');
}

document.addEventListener('click', (e) => {
    if (!e.target.closest('.acciones-admin-pregunta')) {
        document.querySelectorAll('.menu-desplegable-admin').forEach(m => {
            m.classList.add('oculto');
        });
    }
});