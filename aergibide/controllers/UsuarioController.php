<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/UsuarioModel.php';
require_once __DIR__ . '/../models/PreguntaModel.php';
require_once __DIR__ . '/../models/ArchivoModel.php';

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
        $usuarios = UsuarioModel::getAll();
        $this->render('menuadmin.view.php', [
            "usuarios" => $usuarios
            ]);
        
    }
    
    public function store() {
        $nombre = $_GET["nombre"] ?? "";
        $email = $_GET["email"] ?? "";
        $tipo = $_GET["tipo"] ?? "";
        $password = $_GET["password"] ?? "";


        $usuario = [
            "nombre" => $nombre,
            "email" => $email,
            "tipo" => $tipo,
            "password" => $password  
        ];
        UsuarioModel::create($usuario);
        BaseController::redirect("index.php?controller=UsuarioController&accion=show");
    }
    
    public function destroy() {
        $id = [
            "id" => $_GET["id"]
        ];
        UsuarioModel::deleteById($id);
        BaseController::redirect("index.php?controller=UsuarioController&accion=show");
    }
    
    public function edit() {
        $usuario = UsuarioModel::getUserById($_GET["id"] ?? 0);

        if(!$usuario){
           $this->redirect("index.php?controller=UsuarioController&accion=show");
        }

        $this->render("edit_usuario.view.php", ["usuario" => $usuario]);
    }

    public function update(){
        UsuarioModel::update([
            "id"       => $_GET["id"] ?? "",
            "nombre"   => $_GET["nombre"] ?? "",
            "email"    => $_GET["email"] ?? "",
            "tipo"     => $_GET["tipo"] ?? "",
            "password" => $_GET["password"] ?? ""
        ]);
       
        $this->redirect("index.php?controller=UsuarioController&accion=show");

    }



}