<article class="pregunta">
    <div class="pregunta-header">
        <a href="index.php?controller=usuarioController" class="pregunta-usuario">
            <img  style="width: 30px; height: 30px; border-radius: 50%; background-color: var(--color-secundario);" class="avatar" src="<?=$pregunta->ruta_archivo?>" alt="Foto de perfil">
            <small><?=$pregunta->nombre?></small>
        </a>
        <div class="pregunta-meta">
            <small><?=$pregunta->datetime?></small>
            <i class="bi bi-three-dots"></i>
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