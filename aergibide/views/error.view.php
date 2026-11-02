<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aergibide | Error 404</title>
    <link rel="icon" type="image/png" href="views/components/Aergibide.png">
    <link rel="stylesheet" href="styles/style_general.css">
    <link rel="stylesheet" href="styles/viewsStyles/index.view.css">
    <link rel="stylesheet" href="styles/viewsStyles/error.view.css">
    <!-- Biblioteca de Iconos-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <?php require __DIR__ . '/layout/header.php'; ?>
    
    <main class="errorContenedor">
        
        <h1>Error 404</h1>
        <p>Lo sentimos, esta pagina no esta disponible.</p>
        <a class="hacerPregunta" href="index.php">Volver al Inicio</a>
        
    </main>

    <?php require __DIR__ . '/layout/footer.php'; ?>
    
</body>
</html>