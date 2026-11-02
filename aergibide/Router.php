<?php

require_once __DIR__ . '/controllers/BaseController.php';

class Router {
    
    // Como el router no tiene estados, los métodos pueden ser estáticos.
    public static function dispatch() {

        

        // Determinar controlador (por defecto EmpleadoController)
        $controllerName = $_POST['controller'] ?? $_GET['controller'] ?? 'PreguntaController';
        
        // Mirar por cada peticion si el usuario esta logeado.
        if($controllerName != 'UsuarioController'){
            $requireLogin = new BaseController();
            $requireLogin->requireLogin();
        }

        // Determinar acción (por defecto index)
        $action = $_POST['accion'] ?? $_GET['accion'] ?? 'index';
        
        // Cargar y ejecutar controlador
        self::loadController($controllerName, $action);
    }
    
private static function loadController($controllerName, $action) {
    try {
        $controllerFile = __DIR__ . "/controllers/{$controllerName}.php";

        if (!file_exists($controllerFile)) {
            throw new Exception("El controlador '{$controllerName}' no existe.");
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            throw new Exception("La clase '{$controllerName}' no existe dentro del archivo.");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            throw new Exception("El método '{$action}' no existe en el controlador '{$controllerName}'.");
        }

        $controller->$action();

    } catch (Throwable $e) {
        http_response_code(404);

        $mensajeError = $e->getMessage();

        $errorFile = __DIR__ . "/views/error.view.php";
        require_once $errorFile;
    }
}

}