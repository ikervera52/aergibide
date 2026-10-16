<?php
require_once __DIR__ . '/Database.php';

class PreguntaModel {
    
    public static function getAll() {
        $db = Database::getConnection();

        $query = $db->prepare("SELECT 
                                pr.titulo, 
                                pr.contenido, 
                                pr.datetime, 
                                pr.misma_pregunta, 
                                us.nombre
                            FROM preguntas pr 
                            INNER JOIN usuarios us ON pr.id_usuario = us.id;");
        
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
    public static function getById($id) {
        
    }
    
    public static function create($datos) {
        
    }
    
    public static function deleteById($id) {
        
    }
    
    public static function deleteAll() {
        
    }
}