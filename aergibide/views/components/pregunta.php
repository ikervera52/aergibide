<article class="pregunta" data-pregunta-id="<?=$pregunta->id?>" data-usuario-id="<?= (int)$pregunta->usuario_id ?>">
    <!-- Cabecera: Usuario a la izquierda, Fecha a la derecha -->
    <div class="pregunta-header">
        <a href="index.php?controller=UsuarioController&accion=perfil&id=<?= (int)$pregunta->usuario_id ?>" class="pregunta-usuario">
            <img  style="width: 30px; height: 30px; border-radius: 50%; background-color: var(--color-secundario);" class="avatar" src="<?=$pregunta->ruta_archivo?>" alt="Foto de perfil">
            <small><?=$pregunta->nombre?></small>
        </a>
        <div class="pregunta-meta">
            <small><?=$pregunta->datetime?></small>
            <?php if($tipoUsuario == "admin") : ?>
                <div class="acciones-admin-pregunta">
                    <i class="bi bi-three-dots btn-menu-admin" onclick="toggleMenuAdmin(this)"></i>
                    
                    <div class="menu-desplegable-admin oculto">
                        <button class="opcion-eliminar" onclick="eliminarPregunta(this, <?=$pregunta->id ?? 0; ?>)">
                            <i style="color: var(--color-rojo)"class="bi bi-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <a href="index.php?controller=respuestaController&id=<?=$pregunta->id?>" class="pregunta-body">
        <h3><?=$pregunta->titulo?></h3>
        <p><?=mb_strimwidth($pregunta->contenido, 0, 100, "...")?></p>
    </a>
    
    <div class="pregunta-footer">
        <?php if($pregunta->estado != "abierta") : ?>
        <div class="pregunta-resuelta">
            <i class="bi bi-check2-circle"></i>
            <h4> Resuelta</h4>
        </div>
        <?php endif; ?>
        <button onclick="guardarMismaPregunta(<?=$pregunta->id?>, this)" class="<?=$pregunta->marcada_por_usuario == 1 ? "seleccionada" : ""?>">Misma pregunta <i class="bi bi-hand-index-thumb"></i></button>
        <small class="respuestas-count"><?=$pregunta->respuestas_count?> respuestas</small>

    </div>
</article>

<script src="scripts/misma_pregunta.js"></script>
<script src="scripts/toogle_menu_admin.js"></script>
<script src="scripts/eliminar_pregunta_admin.js"></script>

