async function votarRespuesta(respuestaId, btnVotar) {
    try{

        if(btnVotar.classList.contains("seleccionada")){

            let response = await fetch("index.php?controller=RespuestaController&accion=removeVoto", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ respuesta_id: respuestaId})
        });
            
        if(response.ok){
                btnVotar.classList.remove("seleccionada");  
            }else{
                alert("Problemas con el servidor. Intentalo más tarde.");
            }

        }else{
            let response = await fetch("index.php?controller=RespuestaController&accion=saveVoto", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ respuesta_id: respuestaId})
        });

        if(response.ok){
            btnVotar.classList.add("seleccionada");  
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