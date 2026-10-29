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

    <?php 
    // Comprobamos si hay filtros activos para saber si debemos mostrar el panel
    $hayFiltrosActivos = !empty($_POST['categoria']) || !empty($_POST['fecha']);

    $catSeleccionada = $_POST['categoria'] ?? '';
    $fechaSeleccionada = $_POST['fecha'] ?? '';
    $textoBuscado = $_POST['buscar'] ?? '';

    ?>

    <?php require "layout/header.php"; ?>

    <main>

    <div class="contenedorBuscador">
        <h1>Bienvenido/a, <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>!</h1>

        <a class="hacerPregunta" href="index.php?accion=create">Hacer una pregunta <i class="bi bi-person-raised-hand"></i> </a>

        <div class="buscadorConFiltro">
            <form class="buscador" id="formBuscador" action="index.php" method="POST">
                <div>
                    <input type="text" name="buscar" id="buscar" placeholder="Que quieres buscar..." value="<?=$textoBuscado ?? "" ?>">
                    <input type="hidden" name="accion" value="filter">
                    <button class="btn-buscar" type="submit"><i class="bi bi-search" style="color: var(--color-negro)" ></i></button>
                </div>
            </form>
            <button type="button" class="filtros" id="filtros">
                <i id="iconoFiltro" class="<?=$hayFiltrosActivos ? 'bi bi-x-lg' : 'bi bi-filter' ?>"></i>
            </button>
        </div>
    </div>

    <div class="contenedorFiltros" id="contenedorFiltros" <?= $hayFiltrosActivos ? '' : 'hidden' ?>>
        <div class="contenedorFiltrosHijo">
            <select name="categoria" id="categoria" form="formBuscador">
                <option value="" disabled <?= empty($catSeleccionada) ? 'selected' : '' ?>>Por categoria</option>
                <?php foreach($categorias as $categoria) : ?>
                    <option value="<?=$categoria->id?>" <?= ($catSeleccionada == $categoria->id) ? 'selected' : '' ?>>
                        <?=$categoria->nombre?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="fecha" id="fecha" form="formBuscador">
                <option value="" disabled <?= empty($fechaSeleccionada) ? 'selected' : '' ?>>Por fecha</option>
                <option value="semana" <?= ($fechaSeleccionada === 'semana') ? 'selected' : '' ?>>Ultima semana</option>
                <option value="mes" <?= ($fechaSeleccionada === 'mes') ? 'selected' : '' ?>>Ultimo mes</option>
                <option value="seis_meses" <?= ($fechaSeleccionada === 'seis_meses') ? 'selected' : '' ?>>Ultimos seis meses</option>
            </select>

        <button type="submit" form="formBuscador">Buscar</button>
        <button type="button" id="btnLimpiar">Limpiar filtros</button>
        </div>
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
    
    <script>
        document.getElementById("filtros").addEventListener("click", mostrarFiltros);


        function mostrarFiltros(){
            panelFiltros = document.getElementById("contenedorFiltros");
            iconoFiltro = document.getElementById("iconoFiltro");

            if(panelFiltros.hidden){
                panelFiltros.hidden = false;
                iconoFiltro.className = 'bi bi-x-lg';
            }else{
                panelFiltros.hidden = true;
                iconoFiltro.className = 'bi bi-filter';
            }
        }

        document.getElementById('btnLimpiar').addEventListener('click', () => {
            const contenedor = document.getElementById('contenedorFiltros');
            const selects = contenedor.querySelectorAll('select');
    
            selects.forEach(select => {
                select.selectedIndex = 0;
            });
        });
    </script>
</body>
</html>
