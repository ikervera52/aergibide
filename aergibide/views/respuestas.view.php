<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/png" href="views/components/Aergibide.png">
    <link rel="stylesheet" href="styles/style_general.css">
    <link rel="stylesheet" href="styles/viewsStyles/index.view.css">
    <link rel="stylesheet" href="styles/componentsStyles/pregunta.css">
    <link rel="stylesheet" href="styles/viewsStyles/respuestas.view.css">
    <!-- Biblioteca de Iconos-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
    <?php require "layout/header.php"; ?>

    <main>

        <div class="acciones">
            <a href="index.php"> <i style="font-size: 18px; margin-left: -8px " class="bi bi-chevron-left"></i> Volver</a>
        </div>

        <div class="pregunta">
            <div class="pregunta-header">
                <a href="index.php?controller=usuarioController" class="pregunta-usuario">
                    <img  style="width: 30px; height: 30px; border-radius: 50%; background-color: var(--color-secundario);" class="avatar" src="<?=$pregunta->ruta_archivo?>" alt="Foto de perfil">
                    <small><?=$pregunta->nombre?></small>
                    <?php if($pregunta->tipo_usuario == "admin") : ?>
                    <i style="font-size: 15px; margin-left: -3px;" class="bi bi-check-circle"></i>
                    <?php endif; ?>
                </a>
                
                <div class="pregunta-meta">
                    <div class="categoriaPregunta">
                        <small><?=$pregunta->categoria?></small>
                    </div>
                    <small><?=$pregunta->datetime?></small>
                </div>
            </div>

            <div class="pregunta-body">
                <h3><?=$pregunta->titulo?></h3>
                <?php if(isset($pregunta->ruta_archivo_adjunto)) : ?>
                    <img class="pregunta-imagen" src="<?=$pregunta->ruta_archivo_adjunto?>" alt="Imagen adjunta a la pregunta">
                <?php endif; ?>
                <p class="contenido"><?=$pregunta->contenido?></p>
            </div>
            
            <div class="pregunta-footer">
                <button onclick="guardarMismaPregunta(<?=$pregunta->id?>, this)" class="<?=$pregunta->marcada_por_usuario == 1 ? "seleccionada" : ""?>" id="btn-misma-pregunta-<?=$pregunta->id?>">Misma pregunta <i class="bi bi-hand-index-thumb"></i></button>

                <small class="respuestas-count"><?=$pregunta->respuestas_count?> respuestas</small>

                <?php if($pregunta->estado == "abierta") : ?>
                    <div class="pregunta-footer-acciones">
                        <button id="btn-responder">Responder <i class="bi bi-chat-left"></i></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if(!empty($respuestas)) : ?>
            <?php foreach($respuestas as $respuesta) : ?>
                <div class="pregunta <?=$respuesta->seleccionada == 1 ? "respuesta-seleccionada" : ""?>">

                    <?php if($respuesta->seleccionada == 1) : ?>
                        <div class="mensaje-respuesta-seleccionada">
                            <i class="bi bi-check2-circle"></i>
                            <h4> Respuesta seleccionada</h4>
                        </div>
                    <?php endif; ?>

                    <div class="pregunta-header">
                        <a href="index.php?controller=usuarioController" class="respuesta-usuario">
                            <img  style="width: 30px; height: 30px; border-radius: 50%; background-color: var(--color-secundario);" class="avatar" src="<?=$respuesta->ruta_archivo?>" alt="Foto de perfil">
                            <small><?=$respuesta->nombre?></small>
                            <?php if($respuesta->tipo_usuario == "admin") : ?>
                            <i style="font-size: 15px; margin-left: -3px;" class="bi bi-check-circle"></i>
                            <?php endif; ?>
                        </a>

                        <div class="pregunta-meta">
                            <small><?=$respuesta->datetime?></small>
                            <?php if($tipoUsuario == "admin") : ?>
                                <div class="acciones-admin-pregunta">
                                    <i class="bi bi-three-dots btn-menu-admin" onclick="toggleMenuAdmin(this)"></i>
                                    
                                    <div class="menu-desplegable-admin oculto">
                                        <button class="opcion-eliminar" onclick="eliminarRespuesta(this, <?=$respuesta->id ?? 0; ?>)">
                                            <i style="color: var(--color-rojo)"class="bi bi-trash"></i> Eliminar
                                        </button>
                                        
                                        <?php if($pregunta->estado == "abierta") :?>
                                            <button class="opcion-seleccionar" onclick="seleccionarRespuesta(this, <?=$respuesta->id ?? 0; ?>, <?=$pregunta->id?>)">
                                                <i style="color: var(--color-verde)"class="bi bi-check2-circle"></i> Correcta
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="pregunta-body">
                        <?php if(isset($respuesta->ruta_archivo_adjunto)) : ?>
                            <img class="pregunta-imagen" src="<?=$respuesta->ruta_archivo_adjunto?>" alt="Imagen adjunta a la pregunta">
                        <?php endif; ?>
                        <p class="contenido"><?=$respuesta->contenido?></p>
                    </div>

                    <div class="pregunta-footer">
                        <button onclick="votarRespuesta(<?=$respuesta->id?>, this)" class="<?=$respuesta->marcada_por_usuario == 1 ? "seleccionada" : ""?>" ><i class="bi bi-arrow-up-circle"></i><?=$respuesta->puntuacion?></button>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>

        <?php if($pregunta->estado == "abierta") : ?>
            <div class="formulario-respuesta">
                <p>Tienes la respuesta?</p>
                <form action="index.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="pregunta_id" value="<?=$pregunta->id?>">
                    <textarea name="contenido" id="contenido" placeholder="Escribe tu respuesta aquí..." required></textarea>
                    <input type="file" id="archivo" name="archivo">
                
                    <?php if(isset($error)) : ?>

                    <small style="color: var(--color-rojo);"><?=$error?></small>
                
                    <?php endif; ?>
                    <div class="acciones">
                        <input type="hidden" name="controller" value="RespuestaController">
                        <input type="hidden" name="accion" value="store">
                        <input type="hidden" name="tipo-interaccion" value="respuesta">
                        <input type="submit" value="Enviar">
                    </div>
                </form>
            </div>
        <?php endif; ?>

    </main>


    <?php require "layout/footer.php"; ?>

    <script src="scripts/misma_pregunta.js"></script>
    <script src="scripts/toogle_menu_admin.js"></script>
    <script src="scripts/eliminar_respuesta_admin.js"></script>
    <script src="scripts/seleccionar_respuesta_admin.js"></script>
    <script src="scripts/voto.js"></script>
    <script>
        document.getElementById('btn-responder').addEventListener('click', function() {
            window.scrollTo({
                top: document.body.scrollHeight, 
                behavior: 'smooth'              
            });
        });
    </script>
</body>
</html>

