<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Cual es tu duda?</title>

    <link rel="stylesheet" href="styles/style_general.css">
    <link rel="stylesheet" href="styles/viewsStyles/pregunta_form.view.css">
    <link rel="stylesheet" href="styles/componentsStyles/pregunta.css">
    <!-- Biblioteca de Iconos-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>

    <?php require "layout/header.php"; ?>

    <main>

        <h1>¿ Cuál es tu duda ?</h1>
        
        <form action="index.php" method="POST" enctype="multipart/form-data">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" placeholder="Título..." required value="<?= isset($old['titulo']) ? $old['titulo'] : '' ?>">

            <label for="contenido">Pregunta</label>
            <textarea name="contenido" id="contenido" placeholder="¿Cual es tu duda?" required><?= isset($old['contenido']) ? $old['contenido'] : '' ?></textarea>

            <label for="archivo">Archivos</label>

            <label for="archivo" class="archivos" id="archivos">
                <span id="texto-archivo">Arrastra tu archivo aquí</span>
                <input type="file" id="archivo" name="archivo" multiple>
            </label>

            <?php if(isset($error)) : ?>

                <p><?=$error?></p>
                
            <?php endif; ?>

            <div class="acciones">
                <a href="index.php">Cancelar</a>
                
                <input type="hidden" name="accion" value="store">
                <input type="submit" value="Hacer pregunta">
            </div>
        </form>

    </main>

    <?php require "layout/footer.php"; ?>

    <script>
        document.getElementById('archivo').addEventListener('change', function(e) {
            const contenedor = document.getElementById("archivos");
            const texto = document.getElementById('texto-archivo');
            const archivos = e.target.files;

            if (archivos.length === 0) {
                texto.textContent = 'Arrastra tus archivos aquí';
            } else {
                texto.textContent = 'Archivo seleccionado: ' + archivos[0].name;
            }
        });
    </script>

</body>
</html>