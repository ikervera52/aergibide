<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/style_general.css">
    <!-- Biblioteca de Iconos-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <?php require "layout/header.php"; ?>

    <main>

    <h1>Bienvenido, Usuario!</h1> <!-- Falta poner la variable de nombre usuario -->

    <a href="">Hacer una pregunta <i class="bi bi-person-raised-hand"></i> </a>

    <form action="index.php" method="POST">
        <div>
            <input type="text" name="buscar" id="buscar">
            <label for="buscar"><i class="bi bi-search"></i></label>
        </div>
        <button>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
                <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
            </svg>
        </button>
    </form>

    <?php foreach() :?>

    </main>

    <?php require "layout/footer.php"; ?>
    
</body>
</html>
