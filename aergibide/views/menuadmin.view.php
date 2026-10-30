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
    <link rel="stylesheet" href="styles/componentsStyles/formulario_usuario.css">
    <link rel="stylesheet" href="styles/viewsStyles/menuadmin.view.css">
    <!-- Biblioteca de Iconos-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php require "layout/header.php"; ?>

    <main>
        <?php
        $pestana = ($_GET["pestaña"] ?? "gestion") === "destacadas" ? "destacadas" : "gestion";
        ?>

        <nav class="pestañas">
            <a href="index.php?controller=UsuarioController&accion=show&pestaña=gestion"
                class="pestana <?= $pestana === "gestion" ? "activa" : "" ?>">Gestion Usuarios</a>
            <a href="index.php?controller=UsuarioController&accion=show&pestaña=destacadas"
                class="pestana <?= $pestana === "destacadas" ? "activa" : "" ?>">Mayores Dudas</a>
        </nav>

        
        <section id="gestionUsuarios" class="seccion" <?= $pestana !== "gestion" ? "hidden" : "" ?>>
            <div>
            <div class="contenedorBuscador">
                
                <form class="buscador" action="index.php?controller=UsuarioController&accion=filter" method="POST">
                    <div>
                        <input type="text" name="buscar" id="buscar" placeholder="Que email quieres buscar...">
                        <input type="hidden" name="accion" value="filter">
                        <button class="btn-buscar" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                    <button class="filtros">
                    <i class="bi bi-filter"></i>
                    </button>
                </form>
            </div>
            <table>
                <?php if(isset($usuarios)):?>
                    <?php if (empty($usuarios)): ?>
                                <p>No se encontró ningún usuario con ese email.</p>
                            <?php else: ?>
                                <tr><th>Nombre</th><th>Email</th><th>Tipo</th><th>Acciones</th></tr>
                            <?php foreach($usuarios as $valor):?>
                                <tr><td><?= $valor["nombre"]?>
                                </td><td><?= $valor["email"]?></td>
                                <td><?= $valor["tipo"]?></td>

                                <td>
                                    <!-- EDITAR: redirige a la página de edición con el id -->
                                    <form action="index.php" method="get" >
                                        <input type="hidden" name="controller" value="UsuarioController">
                                        <input type="hidden" name="accion" value="edit">
                                        <input type="hidden" name="id" value="<?= $valor['id'] ?>"> 
                                        <button type="submit" style="background: var(--color-naranja); color: var(--color-negro)">Editar</button>
                                    </form>

                                    <!-- ELIMINAR: borra el usuario con ese id -->
                                    <form action="index.php" method="get" onsubmit="confirmarBorrado(event, this);">
                                        <input type="hidden" name="controller" value="UsuarioController">
                                        <input type="hidden" name="accion" value="destroy">
                                        <input type="hidden" name="id" value="<?= $valor['id'] ?>">
                                        <button type="submit" style="background: var(--color-rojo)">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        
                        <?php endforeach;?>
                    <?php endif; ?>
                <?php endif; ?>    
            </table>
            </div>
            <div>    
            <?php $modo = "crear"; require __DIR__ . "/components/formulario_usuario.php"; ?>
            </div>
        </section>
        
        <section id="preguntasDestacadas" class="seccion" <?= $pestana !== "destacadas" ? "hidden" : "" ?>>   
            <?php foreach($preguntas as $pregunta) :
            
            
                require "components/pregunta.php";
        
            endforeach; ?>
        </section>

    </main>
    <?php require "layout/footer.php"; ?>

<script>
function confirmarBorrado(event, formulario) {

    event.preventDefault();

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se podrá deshacer",
        showCancelButton: true,
        confirmButtonColor: '#5F46CB',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            formulario.submit();
        }
    });
}
</script>

</body>
</html>