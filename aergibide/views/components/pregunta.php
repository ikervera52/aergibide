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
        <button onclick="guardarMismaPregunta(<?=$pregunta->id?>, this)" class="<?=$pregunta->marcada_por_usuario == 1 ? "seleccionada" : ""?>" id="btn-misma-pregunta-<?=$pregunta->id?>">Misma pregunta <i class="bi bi-hand-index-thumb"></i></button>

        <small class="respuestas-count"><?=$pregunta->respuestas_count?> respuestas</small>
    </div>
</article>

<script>
    
async function guardarMismaPregunta(preguntaId, btnMismaPregunta) {
    try{

        if(btnMismaPregunta.classList.contains("seleccionada")){

            let response = await fetch("index.php?accion=removeMismaPregunta", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ pregunta_id: preguntaId})
        });
            
        if(response.ok){
                btnMismaPregunta.classList.remove("seleccionada");  
            }else{
                alert("Problemas con el servidor. Intentalo más tarde.");
            }

        }else{
            let response = await fetch("index.php?accion=saveMismaPregunta", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ pregunta_id: preguntaId})
        });

        if(response.ok){
            btnMismaPregunta.classList.add("seleccionada");  
        }else{
            alert("Problemas con el servidor. Intentalo más tarde.");
        }
        }
    }
    catch(error){
        console.error("Error al guardar la misma pregunta:", error);
        alert("Ocurrió un error. Intentalo más tarde.");
    }
}
</script>