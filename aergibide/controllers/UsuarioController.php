<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/UsuarioModel.php';

class UsuarioController extends BaseController {
    
    public function index() {

        if (isset($_SESSION['user_id'])) {
            // Ya hay sesión: no enseño el login, voy a las preguntas
            $this->redirect('index.php?controller=PreguntaController');
        }

        $this->render('login.view.php');
    }

    public function login() {
        $datos = json_decode(file_get_contents('php://input'), true);

        $usuario = UsuarioModel::getUserByEmail($datos['email']);

        if ($usuario && $usuario->contrasena == $datos['password']) {
            $_SESSION['user_id'] = $usuario->id;
            $_SESSION['user_name'] = $usuario->nombre;
            $_SESSION['user_tipo'] = $usuario->tipo;
            $this->json(['ok' => true]);
        } else {
            $this->json(['ok' => false]);
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('index.php?controller=UsuarioController');
    }
    
    public function show() {
        
    }
    
    public function store() {
        
    }
    
    public function destroy() {
        
    }
    
    public function destroyAll() {
        
    }
}