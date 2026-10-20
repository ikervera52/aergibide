<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/UsuarioModel.php';

class UsuarioController extends BaseController {
    
    public function index() {

        if (isset($_SESSION['usuario'])) {
            // Ya hay sesión: no enseño el login, voy a las preguntas
            $this->redirect('index.php?controller=PreguntaController');
        }

        $this->render('login.view.php');
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
    
    public function show() {
        
    }
    
    public function store() {
        
    }
    
    public function destroy() {
        
    }
    
    public function destroyAll() {
        
    }
}