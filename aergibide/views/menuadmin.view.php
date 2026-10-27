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
        
    <form id="formUsuario" action="index.php" method="get" novalidate>
        <fieldset>
            <legend>Nuevo Usuario</legend>

        <input type="text" name="nombre" placeholder="Nombre">
        <span class="error"></span>

        <input type="email" name="email" placeholder="Email">
        <span class="error"></span>

        <select name="tipo">
            <option value="admin" selected>admin</option>
            <option value="standar">standar</option>
        </select>
        <span class="error"></span>

        <input type="password" name="password" placeholder="Password">
        <span class="error"></span>


            <button type="submit" value="anidar">Registrar</button>
            <input type="hidden" name="controller" value="UsuarioController">
            <input type="hidden" name="accion" value="store">
        </fieldset>
    </form>
        <style>
            #formUsuario .error {
                display: block;
                color: red;
                font-size: 0.85em;
                min-height: 1.2em;
            }
        </style>

        <script>
            const reglas = {
                nombre:   /^[A-Z][a-z]{4,14}$/,
                email:    /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                tipo:     /^(admin|standar)$/,
                password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,20}$/
            };

            const form = document.getElementById("formUsuario");

            function validarCampo(nombre) {
                const campo = form.elements[nombre];
                const aviso = campo.nextElementSibling; // el <span> que va justo debajo
                const valido = reglas[nombre].test(campo.value);

                aviso.textContent = valido ? "" : "Dato incorrecto";
                return valido;
            }

            form.addEventListener("submit", function (e) {
                let todoOk = true;

                for (const nombre in reglas) {
                    if (!validarCampo(nombre)) {
                        todoOk = false;
                    }
                }

                if (!todoOk) {
                    e.preventDefault(); // no envía el formulario si algo falla
                }
                });

                // Opcional: revalida cada campo al salir de él
                for (const nombre in reglas) {
                    form.elements[nombre].addEventListener("blur", () => validarCampo(nombre));
                }
        </script>


    </div>
    </main>

    <?php require "layout/footer.php"; ?>

</body>
</html>