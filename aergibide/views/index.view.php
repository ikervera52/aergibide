<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aergibide | Inicio</title>
    <link rel="icon" type="image/png" href="views/components/Aergibide.png">
    <link rel="stylesheet" href="styles/style_general.css">
    <link rel="stylesheet" href="styles/viewsStyles/index.view.css">
    <link rel="stylesheet" href="styles/componentsStyles/pregunta.css">
    <!-- Biblioteca de Iconos-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <?php require "layout/header.php"; ?>

    <main>

    <div class="contenedorBuscador">
        <h1>Bienvenido/a, <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>!</h1>

        <a class="hacerPregunta" href="index.php?accion=create">Hacer una pregunta <i class="bi bi-person-raised-hand"></i> </a>

        <form class="buscador" action="index.php" method="POST">
            <div>
                <input type="text" name="buscar" id="buscar" placeholder="Que quieres buscar...">
                <input type="hidden" name="accion" value="filter">
                <button class="btn-buscar" type="submit"><i class="bi bi-search"></i></button>
            </div>
            <button class="filtros">
            <i class="bi bi-filter"></i>
            </button>
        </form>
    </div>

    <?php if(empty($preguntas)) : ?>

        <p>No hay preguntas que coincidan con tu búsqueda.</p>

    <?php else : ?>

        <?php foreach($preguntas as $pregunta) :
            
            
            require "components/pregunta.php";
        
        endforeach; ?>
    <?php endif; ?>

    </main>

    <?php require "layout/footer.php"; ?>
    
</body>
</html>
