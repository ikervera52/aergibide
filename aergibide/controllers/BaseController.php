<?php

class BaseController {
    
    protected function render($view, $data = []) {
        // Extraer variables para la vista. Explicación:
        // La función extract() convierte un array asociativo en variables individuales.
        // Por ejemplo, si $data = ['titulo' => 'Hola', 'total' => 5],
        // entonces después de llamar a extract($data), tendremos dos variables:
        // $titulo y $total.
        extract($data);

        // Incluir vista
        require __DIR__ . "/../views/{$view}";
    }
    
    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }

    public function requireLogin() {
        if (!isset($_SESSION['usuario'])) {
            $this->redirect('index.php?controller=UsuarioController');
        }
    }


    protected function json($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
    }

    protected function guardarArchivo($id) {
            
        $archivoTmp  = $_FILES['archivo']['tmp_name'];
        $nombreOrig  = $_FILES['archivo']['name'];
        $tamano      = $_FILES['archivo']['size'];

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($archivoTmp);

        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
        $extension = strtolower(pathinfo($nombreOrig, PATHINFO_EXTENSION));

        if (!in_array($extension, $extensionesPermitidas)) {
            $this->mostrarError("Este tipo de archivo no esta permitido.", $id);
        }

        if ($tamano > 30 * 1024 * 1024) {
            $this->mostrarError("El archivo supera el tamaño máximo permitido (30MB)", $id);
        }

        $nuevoNombre = uniqid('foto_', true) . '.' . $extension;
        
        $directorioDestino = __DIR__ . '/../uploads/' . $nuevoNombre;

        if (move_uploaded_file($archivoTmp, $directorioDestino)) {
            
            $rutaParaBD = './uploads/' . $nuevoNombre;

            if($_POST["tipo-interaccion"] == "pregunta"){

                $datos = [
                    "pregunta_id" => $id,
                    "nombre" => $nuevoNombre,
                    "ruta_archivo" => $rutaParaBD,
                    "mime_tipo" => $mimeType,
                    "tamano" => $tamano
                ];

                ArchivoModel::createPregunta($datos);

            } elseif ($_POST["tipo-interaccion"] == "respuesta"){
                $datos = [
                    "respuesta_id" => $id,
                    "nombre" => $nuevoNombre,
                    "ruta_archivo" => $rutaParaBD,
                    "mime_tipo" => $mimeType,
                    "tamano" => $tamano
                ];

                ArchivoModel::createRespuesta($datos);
            }

            

        } else {
            $this->mostrarError("Error al intentar mover el archivo a la carpeta", $id);
        }
    }

}