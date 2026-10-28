<?php
require_once __DIR__ . '/Database.php';

class RespuestaModel {
    
    public static function getByPreguntaId($pregunta_id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT 
                                re.id, re.contenido, re.datetime, re.usuario_id, re.puntuacion, re.seleccionada,
                                us.nombre,
                                fp.ruta_archivo,
                                ar.ruta_archivo AS ruta_archivo_adjunto,
                                CASE 
                                        WHEN rv.usuario_id IS NOT NULL THEN 1 
                                        ELSE 0 
                                    END AS marcada_por_usuario
                            FROM respuestas re
                            INNER JOIN usuarios us ON re.usuario_id = us.id
                            LEFT JOIN foto_perfil_usuarios fp ON us.foto_perfil_id = fp.id
                            LEFT JOIN archivos ar ON ar.respuesta_id = re.id
                            LEFT JOIN respuestas_votadas rv ON re.id = rv.respuesta_id AND rv.usuario_id = :usuario_id
                            WHERE re.pregunta_id = :pregunta_id
                            ORDER BY re.seleccionada DESC, re.puntuacion DESC");
        $stmt->execute(['pregunta_id' => $pregunta_id, 'usuario_id' => $_SESSION["usuario"]["id"]]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function create($datos) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO respuestas (pregunta_id,usuario_id, contenido) VALUES (:pregunta_id, :usuario_id, :contenido)");
        $stmt->execute($datos);
        return $db->lastInsertId(); 
    }
    
    public static function deleteById($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM respuestas WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public static function saveVoto($datos){
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO respuestas_votadas (respuesta_id, usuario_id) VALUES (:respuesta_id, :usuario_id)");
        return $stmt->execute($datos);
    }
    
    public static function sumarVoto($datos){
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE respuestas SET puntuacion = puntuacion + 1 WHERE id = :respuesta_id");
        $stmt->execute($datos);
    }

    public static function removeVoto($datos){
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM respuestas_votadas WHERE usuario_id = :usuario_id AND respuesta_id = :respuesta_id");
        return $stmt->execute($datos);
    }

    public static function restarVoto($datos){
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE respuestas SET puntuacion = puntuacion - 1 WHERE id = :respuesta_id");
        $stmt->execute($datos);
    }

    public static function selectedById($datos){
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE respuestas SET seleccionada =  1 WHERE id = :respuesta_id");
        return $stmt->execute(["respuesta_id" => $datos]);
    }
    
    public static function deleteAll() {
        
    }
}