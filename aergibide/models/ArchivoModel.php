<?php
require_once __DIR__ . '/Database.php';

class ArchivoModel {
    
    public static function getAll() {
        
    }
    
    public static function getById($id) {
        
    }
    
    public static function createPregunta($datos) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO archivos (pregunta_id, nombre, ruta_archivo, mime_tipo, tamano) VALUES (:pregunta_id, :nombre, :ruta_archivo, :mime_tipo, :tamano)");
        $stmt->execute($datos);
    }
    
    public static function deleteById($id) {
        
    }
    
    public static function deleteAll() {
        
    }
}