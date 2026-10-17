<?php
require_once __DIR__ . '/Database.php';

class PreguntaModel {
    
    public static function getAll() {
        $db = Database::getConnection();

        $query = $db->prepare("SELECT 
                                pr.id,
                                pr.titulo, 
                                pr.contenido, 
                                pr.datetime, 
                                us.nombre,
                                fp.ruta_archivo,
                                COUNT(re.id) AS respuestas_count
                            FROM preguntas pr 
                            INNER JOIN usuarios us ON pr.usuario_id = us.id
                            INNER JOIN foto_perfil_usuarios fp ON us.foto_perfil_id = fp.id
                            LEFT JOIN respuestas re ON pr.id = re.pregunta_id
                            GROUP BY 
                                pr.id, 
                                pr.titulo, 
                                pr.contenido, 
                                pr.datetime, 
                                us.nombre, 
                                fp.ruta_archivo;");
        
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getByContenido($texto) {

        $db = Database::getConnection();

        $query = $db->prepare("SELECT 
                                pr.id,
                                pr.titulo, 
                                pr.contenido, 
                                pr.datetime, 
                                us.nombre,
                                fp.ruta_archivo,
                                COUNT(re.id) AS respuestas_count
                            FROM preguntas pr 
                            INNER JOIN usuarios us ON pr.usuario_id = us.id
                            LEFT JOIN foto_perfil_usuarios fp ON us.foto_perfil_id = fp.id
                            LEFT JOIN respuestas re ON pr.id = re.pregunta_id
                            WHERE pr.contenido LIKE :contenido OR pr.titulo LIKE :titulo
                            GROUP BY 
                                pr.id, 
                                pr.titulo, 
                                pr.contenido, 
                                pr.datetime, 
                                us.nombre, 
                                fp.ruta_archivo;");
        $query->execute($texto);
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