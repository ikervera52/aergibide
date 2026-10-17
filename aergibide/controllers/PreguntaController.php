<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/PreguntaModel.php';

class PreguntaController extends BaseController {
    
    public function index() {

        $preguntas = PreguntaModel::getAll();
        $this->render("../views/index.view.php", ["preguntas" => $preguntas]);
        
    }
    public function filter(){
        $texto = trim($_POST["buscar"] ?? "");
        $preguntasFiltradas = PreguntaModel::getByContenido(['titulo' => "%$texto%", 'contenido' => "%$texto%"]);
        $this->render("../views/index.view.php", ["preguntas" => $preguntasFiltradas]);
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