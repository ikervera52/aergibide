<?php
require_once __DIR__ . '/Database.php';

class ArchivoModel {

    public static function getByUsuarioId($id) {
        $db = Database::getConnection();
        $query = $db->prepare("SELECT a.id, a.nombre, a.ruta_archivo, a.mime_tipo, a.tamano
                            FROM archivos a
                            LEFT JOIN preguntas p ON a.pregunta_id = p.id
                            LEFT JOIN respuestas r ON a.respuesta_id = r.id
                            WHERE p.usuario_id = :id1 OR r.usuario_id = :id2
                            ORDER BY a.id DESC");
        $query->execute(['id1' => $id, 'id2' => $id]);
        return $query->fetchAll();
    } 
    
    public static function getAll() {
        
    }
    
    public static function getById($id) {
        
    }
    
    public static function createPregunta($datos) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO archivos (pregunta_id, nombre, ruta_archivo, mime_tipo, tamano) VALUES (:pregunta_id, :nombre, :ruta_archivo, :mime_tipo, :tamano)");
        $stmt->execute($datos);
    }

    public static function createRespuesta($datos){
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO archivos (respuesta_id, nombre, ruta_archivo, mime_tipo, tamano) VALUES (:respuesta_id, :nombre, :ruta_archivo, :mime_tipo, :tamano)");
        $stmt->execute($datos);
    }
    
    public static function deleteById($id) {
        
    }
    
    public static function deleteAll() {
        
    }
}