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

        $miId = (int)$_SESSION['usuario']['id'];

        // Si viene ?id=... veo ese perfil; si no, el mío
        $id = (int)($_GET['id'] ?? $miId);
        $esMio = ($id === $miId);

        $usuario = UsuarioModel::getUserById($id);

        // El usuario no existe
        if (!$usuario) {
            if ($esMio) {
                $this->redirect('index.php?controller=UsuarioController&accion=logout');
            }
            $this->redirect('index.php?controller=PreguntaController');
        }

        // Lo privado solo se consulta si es mi perfil
        $destacadas = [];
        $archivos = [];
        if ($esMio) {
            $destacadas = PreguntaModel::getDestacadasByUsuarioId($id);
            $archivos = ArchivoModel::getByUsuarioId($id);
        }

        $this->render('perfil.view.php', [
            'usuario'    => $usuario,
            'esMio'      => $esMio,
            'preguntas'  => PreguntaModel::getByUsuarioId($id),
            'destacadas' => $destacadas,
            'archivos'   => $archivos
        ]);
    }
    
    public function actualizar() {
        $this->requireLogin();

        $id = (int)$_SESSION['usuario']['id'];
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($nombre === '' || mb_strlen($nombre) > 50) {
            $this->json(['ok' => false, 'error' => 'El nombre es obligatorio (máximo 50 caracteres).']);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 50) {
            $this->json(['ok' => false, 'error' => 'El email no es válido.']);
        }
        if (UsuarioModel::emailEnUso($email, $id)) {
            $this->json(['ok' => false, 'error' => 'Ese email ya está registrado.']);
        }

        // Foto (opcional): solo si el usuario ha elegido una
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
            $actual = UsuarioModel::getUserById($id);
            $error = $this->guardarFoto($id, $actual);
            if ($error) {
                $this->json(['ok' => false, 'error' => $error]);
            }
        }

        UsuarioModel::updateDatos($id, $nombre, $email);
        $_SESSION['usuario']['nombre'] = $nombre;

        $nuevo = UsuarioModel::getUserById($id);
        $this->json([
            'ok' => true,
            'nombre' => $nuevo->nombre,
            'email' => $nuevo->email,
            'ruta_archivo' => $nuevo->ruta_archivo
        ]);
    }

    // Devuelve el texto del error, o null si todo ha ido bien
    private function guardarFoto($usuarioId, $actual) {
        $foto = $_FILES['foto'];

        if ($foto['error'] !== UPLOAD_ERR_OK) {
            return "Error al subir la foto.";
        }

        $extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        $mimeType = (new finfo(FILEINFO_MIME_TYPE))->file($foto['tmp_name']);

        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])
            || !in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp'])) {
            return "Este tipo de archivo no está permitido.";
        }

        if ($foto['size'] > 30 * 1024 * 1024) {
            return "El archivo supera el tamaño máximo permitido (30MB).";
        }

        $nuevoNombre = uniqid('foto_', true) . '.' . $extension;

        if (!move_uploaded_file($foto['tmp_name'], __DIR__ . '/../uploads/' . $nuevoNombre)) {
            return "Error al intentar mover el archivo a la carpeta.";
        }

        // Registro la foto nueva y se la asigno al usuario
        $fotoId = UsuarioModel::createFoto([
            'nombre' => $nuevoNombre,
            'ruta_archivo' => './uploads/' . $nuevoNombre,
            'mime_tipo' => $mimeType,
            'tamano' => $foto['size']
        ]);
        UsuarioModel::setFoto($usuarioId, $fotoId);

        // Borro la foto anterior (la id 1 es la de por defecto: no se toca)
        if ($actual->foto_perfil_id && $actual->foto_perfil_id != 1) {
            $viejo = realpath(__DIR__ . '/../' . ltrim($actual->ruta_archivo, './'));
            $carpeta = realpath(__DIR__ . '/../uploads');

            if ($viejo && strpos($viejo, $carpeta) === 0) {
                unlink($viejo);
            }
            UsuarioModel::deleteFotoById($actual->foto_perfil_id);
        }

        return null;
    }
}