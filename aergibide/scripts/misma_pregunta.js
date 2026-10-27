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
