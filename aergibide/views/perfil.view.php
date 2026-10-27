<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aergibide | Perfil</title>
    <link rel="stylesheet" href="styles/style_general.css">
    <link rel="stylesheet" href="styles/componentsStyles/pregunta.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles/viewsStyles/perfil.view.css?v=<?php echo filemtime('styles/viewsStyles/perfil.view.css'); ?>">
</head>
<body>

<?php require __DIR__ . '/layout/header.php'; ?>

<main>

    <!-- Cabecera del perfil -->
    <section class="perfilCabecera">
        <img id="perfilFoto" src="<?= htmlspecialchars($usuario->ruta_archivo ?: 'uploads/default-avatar.png') ?>"
             alt="Foto de perfil" class="fotoPerfil">

        <div class="perfilDatos">
            <h1 id="perfilNombre"><?= htmlspecialchars($usuario->nombre) ?></h1>

            <?php if ($esMio): ?>
                <p id="perfilEmail"><?= htmlspecialchars($usuario->email) ?></p>
            <?php endif; ?>

            <small>Desde <?= date('d/m/Y', strtotime($usuario->datetime)) ?></small>
        </div>

        <?php if ($esMio): ?>
            <div class="perfilAcciones">
                <a href="#" id="editar">Editar perfil</a>
                <a href="index.php?controller=UsuarioController&accion=logout" id="logOut">Cerrar sesión</a>
            </div>
        <?php endif; ?>
    </section>

    <?php if ($esMio): ?>
    <form id="formEditar" hidden>
        <label for="inputFoto" class="btn-subir-foto">
            <i class="bi bi-camera"></i> Cambiar foto de perfil
        </label>
        <input type="file" id="inputFoto" name="foto" accept="image/png,image/jpeg,image/webp" hidden>
        <input type="text" id="inputNombre" name="nombre" placeholder="Nombre"
            value="<?= htmlspecialchars($usuario->nombre) ?>" maxlength="50">
        <input type="email" id="inputEmail" name="email" placeholder="Email"
            value="<?= htmlspecialchars($usuario->email) ?>" maxlength="50">

        <p id="mensajeEditar"></p>

        <div>
            <button type="button" id="btnCancelar">Cancelar</button>
            <button type="submit" id="btnGuardar">Guardar</button>
        </div>
    </form>
    <?php endif; ?>

    <!-- Pestañas -->
    <nav class="pestanas">
        <?php if ($esMio): ?>
            <button type="button" id="btnPreguntas" class="pestana activa" onclick="mostrarPreguntas()">Preguntas</button>
            <button type="button" id="btnDestacadas" class="pestana" onclick="mostrarDestacadas()">Destacadas</button>
            <button type="button" id="btnArchivos" class="pestana" onclick="mostrarArchivos()">Archivos adjuntos</button>
        <?php else: ?>
            <!-- Perfil ajeno: solo la pestaña de preguntas -->
            <button type="button" id="btnPreguntas" class="pestana activa">Preguntas</button>
        <?php endif; ?>
    </nav>

    <!-- 1. Preguntas del usuario (se ve siempre) -->
    <section id="preguntas" class="seccion">
        <?php foreach ($preguntas as $pregunta): ?>
            <?php require __DIR__ . '/components/pregunta.php'; ?>
        <?php endforeach; ?>
        <?php if (empty($preguntas)): ?>
            <p><?= $esMio ? 'Aún no has hecho preguntas.' : 'Este usuario aún no ha hecho preguntas.' ?></p>
        <?php endif; ?>
    </section>

    <?php if ($esMio): ?>

        <!-- 2. Preguntas destacadas (solo en mi perfil) -->
        <section id="destacadas" class="seccion" hidden>
            <?php foreach ($destacadas as $pregunta): ?>
                <?php require __DIR__ . '/components/pregunta.php'; ?>
            <?php endforeach; ?>
            <?php if (empty($destacadas)): ?>
                <p>Aún no has destacado ninguna pregunta.</p>
            <?php endif; ?>
        </section>

        <!-- 3. Archivos adjuntos (solo en mi perfil) -->
        <section id="archivos" class="seccion" hidden>
            <?php foreach ($archivos as $archivo): ?>
                <div class="archivo">
                    <a href="<?= htmlspecialchars($archivo->ruta_archivo) ?>" target="_blank">
                        <i class="bi bi-file-earmark"></i>
                        <?= htmlspecialchars($archivo->nombre) ?>
                    </a>
                    <small><?= round($archivo->tamano / 1024) ?> KB</small>
                </div>
            <?php endforeach; ?>
            <?php if (empty($archivos)): ?>
                <p>Aún no has subido archivos.</p>
            <?php endif; ?>
        </section>

    <?php endif; ?>

</main>

<?php if ($esMio): ?>
<script>
const btnPreguntas = document.querySelector('#btnPreguntas');
const btnDestacadas = document.querySelector('#btnDestacadas');
const btnArchivos = document.querySelector('#btnArchivos');
const formEditar = document.querySelector('#formEditar');
const inputFoto = document.querySelector('#inputFoto');
const inputNombre = document.querySelector('#inputNombre');
const inputEmail = document.querySelector('#inputEmail');
const mensajeEditar = document.querySelector('#mensajeEditar');

const seccionPreguntas = document.querySelector('#preguntas');
const seccionDestacadas = document.querySelector('#destacadas');
const seccionArchivos = document.querySelector('#archivos');
const perfilFoto = document.querySelector('#perfilFoto');
const perfilNombre = document.querySelector('#perfilNombre');
const perfilEmail = document.querySelector('#perfilEmail');


function mostrarPreguntas() {
    seccionPreguntas.hidden = false;
    seccionDestacadas.hidden = true;
    seccionArchivos.hidden = true;

    btnPreguntas.classList.add('activa');
    btnDestacadas.classList.remove('activa');
    btnArchivos.classList.remove('activa');
}

function mostrarDestacadas() {
    seccionPreguntas.hidden = true;
    seccionDestacadas.hidden = false;
    seccionArchivos.hidden = true;

    btnPreguntas.classList.remove('activa');
    btnDestacadas.classList.add('activa');
    btnArchivos.classList.remove('activa');
}

function mostrarArchivos() {
    seccionPreguntas.hidden = true;
    seccionDestacadas.hidden = true;
    seccionArchivos.hidden = false;

    btnPreguntas.classList.remove('activa');
    btnDestacadas.classList.remove('activa');
    btnArchivos.classList.add('activa');
}

// Abrir el formulario
function abrirFormulario(evento) {
    evento.preventDefault();
    formEditar.hidden = false;
}

// Cancelar: pongo en los campos lo que se ve ahora en pantalla y cierro
function cancelarEdicion() {
    inputNombre.value = perfilNombre.textContent;
    inputEmail.value = perfilEmail.textContent;
    inputFoto.value = '';
    mensajeEditar.textContent = '';
    formEditar.hidden = true;
}

// Guardar
async function guardarPerfil(evento) {
    evento.preventDefault();
    mensajeEditar.textContent = '';

    // Envío los campos del formulario (nombre, email y foto)
    const datos = new FormData(formEditar);

    const respuesta = await fetch('index.php?controller=UsuarioController&accion=actualizar', {
        method: 'POST',
        body: datos
    });

    const resultado = await respuesta.json();

    if (resultado.ok == true) {
        // Actualizo la pantalla sin recargar
        perfilNombre.textContent = resultado.nombre;
        perfilEmail.textContent = resultado.email;
        perfilFoto.src = resultado.ruta_archivo;

        const miId = <?= (int)$usuario->id ?>;
        const misPreguntas = document.querySelectorAll('article[data-usuario-id="' + miId + '"]');

        misPreguntas.forEach(function (articulo) {
            articulo.querySelector('.avatar').src = resultado.ruta_archivo;
            articulo.querySelector('.pregunta-usuario small').textContent = resultado.nombre;
        });

        inputFoto.value = '';
        formEditar.hidden = true;
    } else {
        mensajeEditar.textContent = resultado.error;
    }
}

// Conecto cada función con su elemento
document.querySelector('#editar').addEventListener('click', abrirFormulario);
document.querySelector('#btnCancelar').addEventListener('click', cancelarEdicion);
formEditar.addEventListener('submit', guardarPerfil);
</script>
<?php endif; ?>

<?php require __DIR__ . '/layout/footer.php'; ?>