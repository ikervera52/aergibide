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
</head>
<body>
<?php require "layout/header.php"; ?>

    <main>


        <nav class="pestañas">
            <button type="button" id="btngestionUsuarios" class="pestana activa" onclick="mostrargestionUsuarios()">Gestion Usuarios</button>
            <button type="button" id="btnpreguntasDestacadas" class="pestana" onclick="mostrarpreguntasDestacadas()">Preguntas Destacadas</button>
        </nav>

        <section id="gestionUsuarios" class="seccion">
            <div>
            <div class="contenedorBuscador">
                
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
            <table>
                <tr><td>Nombre</td><td>Email</td><td>Tipo</td><td>Acciones</td></tr>
                <?php if(isset($usuarios)):?>
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
                                <button type="submit">Editar</button>
                            </form>

                            <!-- ELIMINAR: borra el usuario con ese id -->
                            <form action="index.php" method="get" >
                                <input type="hidden" name="controller" value="UsuarioController">
                                <input type="hidden" name="accion" value="destroy">
                                <input type="hidden" name="id" value="<?= $valor['id'] ?>">
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                        
                    <?php endforeach;?>
                <?php endif; ?>    
            </table>
            </div>
            <div>    
            <?php $modo = "crear"; require __DIR__ . "/components/formulario_usuario.php"; ?>
            </div>
        </section>
        
        <section id="preguntasDestacadas" class="seccion" hidden>
            <h1>Hola</h1>
        </section>

    </main>

    <script>
        const btngestionUsuarios = document.querySelector('#btngestionUsuarios');
        const btnpreguntasDestacadas = document.querySelector('#btnpreguntasDestacadas');


        const secciongestionUsuarios = document.querySelector('#gestionUsuarios');
        const seccionpreguntasDestacadas = document.querySelector('#preguntasDestacadas');

        function mostrargestionUsuarios(){
            secciongestionUsuarios.hidden = false;
            seccionpreguntasDestacadas.hidden = true;

            btngestionUsuarios.classList.add('activa');
            btnpreguntasDestacadas.classList.remove('activa');
        }

        function mostrarpreguntasDestacadas(){
            secciongestionUsuarios.hidden = true;
            seccionpreguntasDestacadas.hidden = false;

            btngestionUsuarios.classList.remove('activa');
            btnpreguntasDestacadas.classList.add('activa');
        }

    </script>
    <?php require "layout/footer.php"; ?>

</body>
</html>