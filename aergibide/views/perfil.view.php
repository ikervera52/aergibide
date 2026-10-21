<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aergibide</title>
    <link rel="stylesheet" href="styles/style_general.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles/viewsStyles/perfil.view.css?v=<?php echo filemtime('styles/viewsStyles/perfil.view.css'); ?>">
</head>
<body>

<?php require __DIR__ . '/layout/header.php'; ?>

<main>

    <!-- Cabecera del perfil -->
    <section class="perfilCabecera">
        <img src="<?=$usuario->ruta_archivo?>"
             alt="Foto de perfil" class="fotoPerfil">

        <div class="perfilDatos">
            <h1><?= htmlspecialchars($usuario->nombre) ?></h1>
            <p><?= htmlspecialchars($usuario->email) ?></p>
            <small>Desde <?= date('d/m/Y', strtotime($usuario->datetime)) ?></small>
        </div>

        <div class="perfilAcciones">
            <a href="#" id="editar">Editar perfil</a>
            <a href="index.php?controller=UsuarioController&accion=logout" id="logOut">Cerrar sesión</a>
        </div>
    </section>

    <!-- Pestañas -->
    <nav class="pestanas">
        <button type="button" id="btnPreguntas" class="pestana activa" onclick="mostrarPreguntas()">Preguntas</button>
        <button type="button" id="btnDestacadas" class="pestana" onclick="mostrarDestacadas()">Destacadas</button>
        <button type="button" id="btnArchivos" class="pestana" onclick="mostrarArchivos()">Archivos adjuntos</button>
    </nav>

    <!-- 1. Preguntas del usuario -->
    <section id="preguntas" class="seccion">
        <?php foreach ($preguntas as $pregunta): ?>
            <?php require __DIR__ . '/components/pregunta.php'; ?>
        <?php endforeach; ?>
        <?php if (empty($preguntas)): ?>
            <p>Aún no has hecho preguntas.</p>
        <?php endif; ?>
    </section>

    <!-- 2. Preguntas destacadas (likes) -->
    <section id="destacadas" class="seccion" hidden>
        <?php foreach ($destacadas as $pregunta): ?>
            <?php require __DIR__ . '/components/pregunta.php'; ?>
        <?php endforeach; ?>
        <?php if (empty($destacadas)): ?>
            <p>Aún no has destacado ninguna pregunta.</p>
        <?php endif; ?>
    </section>

    <!-- 3. Archivos adjuntos -->
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

</main>

<script>
const btnPreguntas = document.querySelector('#btnPreguntas');
const btnDestacadas = document.querySelector('#btnDestacadas');
const btnArchivos = document.querySelector('#btnArchivos');

const seccionPreguntas = document.querySelector('#preguntas');
const seccionDestacadas = document.querySelector('#destacadas');
const seccionArchivos = document.querySelector('#archivos');

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
</script>

<?php require __DIR__ . '/layout/footer.php'; ?>