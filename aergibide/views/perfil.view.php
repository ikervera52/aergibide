<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aergibide</title>
    <link rel="stylesheet" href="styles/style_general.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<?php require __DIR__ . '/layout/header.php'; ?>

<main>
    <section class="perfilCabecera">
        <img src="<?= htmlspecialchars($usuario->ruta_archivo ?: 'uploads/default-avatar.png') ?>"
             alt="Foto de perfil" class="fotoPerfil">

        <div class="perfilDatos">
            <h1><?= htmlspecialchars($usuario->nombre) ?></h1>
            <p><?= htmlspecialchars($usuario->email) ?></p>
            <small>Desde <?= date('d/m/Y', strtotime($usuario->datetime)) ?></small>
        </div>

        <div class="perfilAcciones">
            <a href="#">Editar perfil</a>
            <a href="index.php?controller=UsuarioController&accion=logout">Cerrar sesión</a>
        </div>
    </section>
</main>



<?php require __DIR__ . '/layout/footer.php'; ?>