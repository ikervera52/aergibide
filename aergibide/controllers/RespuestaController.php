<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/UsuarioModel.php';
require_once __DIR__ . '/../models/PreguntaModel.php';
require_once __DIR__ . '/../models/ArchivoModel.php';
require_once __DIR__ . '/../models/RespuestaModel.php';

class RespuestaController extends BaseController {
    
    public function index() {

        $this->render('respuestas.view.php', [
            'pregunta' => PreguntaModel::getById($_GET['id'] ?? 0),
            'respuestas' => RespuestaModel::getByPreguntaId($_GET['id'] ?? 0)
        ]);

    }

    public function login() {
        $datos = json_decode(file_get_contents('php://input'), true);

        $usuario = UsuarioModel::getUserByEmail($datos['email'] ?? '');

        if ($usuario && $usuario->contrasena == ($datos['password'] ?? '')) {

            $_SESSION['usuario'] = [
                'id'     => $usuario->id,
                'nombre' => $usuario->nombre,
                'tipo'   => $usuario->tipo
            ];

            $this->json(['ok' => true]);
        } else {
            $this->json(['ok' => false]);
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('index.php?controller=UsuarioController');
    }

    public function perfil() {
        $this->requireLogin();

        $id = $_SESSION['usuario']['id'];

        $usuario = UsuarioModel::getUserById($id);
        if (!$usuario) {
            $this->redirect('index.php?controller=UsuarioController&accion=logout');
        }

        $this->render('perfil.view.php', [
            'usuario'    => $usuario,
            'preguntas'  => PreguntaModel::getByUsuarioId($id),
            'destacadas' => PreguntaModel::getDestacadasByUsuarioId($id),
            'archivos'   => ArchivoModel::getByUsuarioId($id)
        ]);
    }
    
    public function show() {
        
    }
    
    public function store(){
        $pregunta_id = $_POST["pregunta_id"];
        $contenido = $_POST["contenido"];

        if($pregunta_id === "" || $contenido === ""){
            $this->mostrarError("El titulo y la pregunta son obligatorias.");
        }

        $datos = [
            "pregunta_id" => $pregunta_id,
            "usuario_id" => $_SESSION["usuario"]["id"],
            "contenido" => $contenido
        ];

        $respuesta_id = RespuestaModel::create($datos);

        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK){
            $this->guardarArchivo($respuesta_id);
        }

        $this->redirect("index.php?controller=RespuestaController&id=" . $pregunta_id);
    
    }

    private function mostrarError($error, $id = null){

        if(isset($id)){
            RespuestaModel::deleteById($id);
        }
        $this->render("../views/pregunta_form.view.php", [
                    "error" => $error,
                    "old" => $_POST
                ]);
        die();
    }

    public function saveVoto(){
        $this->requireLogin();

        $data = json_decode(file_get_contents('php://input'), true);
        $respuesta_id = $data['respuesta_id'] ?? null;
        $usuario_id = $_SESSION['usuario']['id'] ?? null;

        if ($respuesta_id && $usuario_id) {

            if(RespuestaModel::saveVoto(['respuesta_id' => $respuesta_id, 'usuario_id' => $usuario_id])){
                RespuestaModel::sumarVoto(['respuesta_id' => $respuesta_id]);
                $this->json(['success' => true]);
            } else{
                $this->json(['success' => false, 'message' => 'Error al guardar el voto.']);
            }
            
        } else {
            $this->json(['success' => false, 'message' => 'Datos incompletos']);
        }
    }

    public function removeVoto(){
        $this->requireLogin();

        $data = json_decode(file_get_contents('php://input'), true);
        $respuesta_id = $data['respuesta_id'] ?? null;
        $usuario_id = $_SESSION['usuario']['id'] ?? null;

        if ($respuesta_id && $usuario_id) {

            if(RespuestaModel::removeVoto(['respuesta_id' => $respuesta_id, 'usuario_id' => $usuario_id])){
                RespuestaModel::restarVoto(['respuesta_id' => $respuesta_id]);
                $this->json(['success' => true]);
            } else{
                $this->json(['success' => false, 'message' => 'Error al eliminar el voto.']);
            }
            
        } else {
            $this->json(['success' => false, 'message' => 'Datos incompletos']);
        }
    }
    
    public function destroy() {
        
    }
    
    public function destroyAll() {
        
    }
}