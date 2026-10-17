<article class="pregunta">
    <!-- Cabecera: Usuario a la izquierda, Fecha a la derecha -->
    <div class="pregunta-header">
        <a href="index.php?controller=usuarioController" class="pregunta-usuario">
            <img  style="width: 30px; height: 30px; border-radius: 50%; background-color: var(--color-secundario);" class="avatar" src="<?=$pregunta->ruta_archivo?>" alt="Foto de perfil">
            <small><?=$pregunta->nombre?></small>
        </a>
        <div class="pregunta-meta">
            <small><?=$pregunta->datetime?></small>
            <i class="bi bi-three-dots"></i> <!-- Icono de los 3 puntos -->
        </div>
    </div>

    <!-- Cuerpo: Título y Contenido recortado -->
    <a href="index.php?controller=respuestaController" class="pregunta-body">
        <h3><?=$pregunta->titulo?></h3>
        <p><?=mb_strimwidth($pregunta->contenido, 0, 100, "...")?></p>
    </a>
    
    <!-- Pie: Botón e info de respuestas alineados horizontalmente -->
    <div class="pregunta-footer">
        <button class="btn-misma-pregunta">Misma pregunta <i class="bi bi-hand-index-thumb"></i></button>
        <small class="respuestas-count"><?=$pregunta->respuestas_count?> respuestas</small>
    </div>
</article>