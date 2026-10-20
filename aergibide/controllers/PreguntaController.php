<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/PreguntaModel.php';
require_once __DIR__ . '/../models/ArchivoModel.php';

class PreguntaController extends BaseController {
    
    public function index() {
         $this->requireLogin();

        $preguntas = PreguntaModel::getAll();
        $this->render("../views/index.view.php", ["preguntas" => $preguntas]);
        
    }
    public function filter(){
         $this->requireLogin();
        $texto = trim($_POST["buscar"] ?? "");
        $preguntasFiltradas = PreguntaModel::getByContenido(['titulo' => "%$texto%", 'contenido' => "%$texto%"]);
        $this->render("../views/index.view.php", ["preguntas" => $preguntasFiltradas]);
    }

    public function create(){
        $this->render("../views/pregunta_form.view.php");
    }

    public function store(){
        $titulo = $_POST["titulo"];
        $contenido = $_POST["contenido"];

        if(!isset($_POST["titulo"]) || !isset($_POST["contenido"])){
            $this->mostrarError("El titulo y la pregunta son requeridas.");
        }

        $datos = [
            "usuario_id" => $_SESSION["usuario"]["id"],
            "titulo" => $titulo,
            "contenido" => $contenido
        ];

        $pregunta_id = PreguntaModel::create($datos);

        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK){
            $this->guardarArchivo($pregunta_id);
        }

        $this->redirect("index.php");
    
    }
    
    private function guardarArchivo($id) {
            
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
            $datos = [
                "pregunta_id" => $id,
                "nombre" => $nuevoNombre,
                "ruta_archivo" => $rutaParaBD,
                "mime_tipo" => $mimeType,
                "tamano" => $tamano
            ];
        
            ArchivoModel::createPregunta($datos);

        } else {
            $this->mostrarError("Error al intentar mover el archivo a la carpeta", $id);
        }
    }

    private function mostrarError($error, $id){

        if(isset($id)){
            PreguntaModel::deleteById($id);
        }
        $this->render("../views/pregunta_form.view.php", [
                    "error" => $error,
                    "old" => $_POST
                ]);
    }

    public function show() {
        
    }
    
    public function destroy() {
        
    }
    
    public function destroyAll() {
        
    }
}