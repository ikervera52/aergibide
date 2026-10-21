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
                                    COUNT(DISTINCT re.id) AS respuestas_count,
                                    CASE 
                                        WHEN pd.usuario_id IS NOT NULL THEN 1 
                                        ELSE 0 
                                    END AS marcada_por_usuario
                                FROM preguntas pr 
                                INNER JOIN usuarios us ON pr.usuario_id = us.id
                                INNER JOIN foto_perfil_usuarios fp ON us.foto_perfil_id = fp.id
                                LEFT JOIN respuestas re ON pr.id = re.pregunta_id
                                LEFT JOIN preguntas_destacadas pd ON pr.id = pd.pregunta_id AND pd.usuario_id = :usuario_id
                                GROUP BY 
                                    pr.id, 
                                    pr.titulo, 
                                    pr.contenido, 
                                    pr.datetime, 
                                    us.nombre, 
                                    fp.ruta_archivo,
                                    pd.usuario_id;");
        
        $query->execute(['usuario_id' => $_SESSION['usuario']['id']]);
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
                                    COUNT(DISTINCT re.id) AS respuestas_count,
                                    CASE 
                                        WHEN pd.usuario_id IS NOT NULL THEN 1 
                                        ELSE 0 
                                    END AS marcada_por_usuario
                                FROM preguntas pr 
                                INNER JOIN usuarios us ON pr.usuario_id = us.id
                                LEFT JOIN foto_perfil_usuarios fp ON us.foto_perfil_id = fp.id
                                LEFT JOIN respuestas re ON pr.id = re.pregunta_id
                                LEFT JOIN preguntas_destacadas pd ON pr.id = pd.pregunta_id AND pd.usuario_id = :usuario_id
                                WHERE pr.contenido LIKE :contenido OR pr.titulo LIKE :titulo
                                GROUP BY 
                                    pr.id, 
                                    pr.titulo, 
                                    pr.contenido, 
                                    pr.datetime, 
                                    us.nombre, 
                                    fp.ruta_archivo,
                                    pd.usuario_id;");
        $query->execute($texto + ['usuario_id' => $_SESSION['usuario']['id']]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
    public static function getByUsuarioId($id) {
        $db = Database::getConnection();
        $query = $db->prepare("SELECT 
                                pr.id, pr.titulo, pr.contenido, pr.datetime, pr.misma_pregunta,
                                us.nombre,
                                fp.ruta_archivo,
                                COUNT(re.id) AS respuestas_count
                            FROM preguntas pr
                            INNER JOIN usuarios us ON pr.usuario_id = us.id
                            LEFT JOIN foto_perfil_usuarios fp ON us.foto_perfil_id = fp.id
                            LEFT JOIN respuestas re ON pr.id = re.pregunta_id
                            WHERE pr.usuario_id = :id
                            GROUP BY pr.id, pr.titulo, pr.contenido, pr.datetime, pr.misma_pregunta, us.nombre, fp.ruta_archivo
                            ORDER BY pr.datetime DESC");
        $query->execute(['id' => $id]);
        return $query->fetchAll();
    }

    public static function getDestacadasByUsuarioId($id) {
        $db = Database::getConnection();
        $query = $db->prepare("SELECT 
                                pr.id, pr.titulo, pr.contenido, pr.datetime, pr.misma_pregunta,
                                us.nombre,
                                fp.ruta_archivo,
                                COUNT(re.id) AS respuestas_count
                            FROM preguntas_destacadas pd
                            INNER JOIN preguntas pr ON pd.pregunta_id = pr.id
                            INNER JOIN usuarios us ON pr.usuario_id = us.id
                            LEFT JOIN foto_perfil_usuarios fp ON us.foto_perfil_id = fp.id
                            LEFT JOIN respuestas re ON pr.id = re.pregunta_id
                            WHERE pd.usuario_id = :id
                            GROUP BY pr.id, pr.titulo, pr.contenido, pr.datetime, pr.misma_pregunta, us.nombre, fp.ruta_archivo
                            ORDER BY pr.datetime DESC");
        $query->execute(['id' => $id]);
        return $query->fetchAll();
    }
    
    public static function create($datos) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO preguntas (usuario_id, titulo, contenido) VALUES (:usuario_id, :titulo, :contenido)");
        $stmt->execute($datos);
        return $db->lastInsertId(); 
    }

    
    public static function deleteById($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM preguntas WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public static function saveMismaPregunta($datos){
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO preguntas_destacadas (usuario_id, pregunta_id) VALUES (:usuario_id, :pregunta_id)");
        return $stmt->execute($datos);
    }
    
    public static function sumarMismaPregunta($datos){
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE preguntas SET misma_pregunta = misma_pregunta + 1 WHERE id = :pregunta_id");
        $stmt->execute($datos);
    }

    public static function removeMismaPregunta($datos){
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM preguntas_destacadas WHERE usuario_id = :usuario_id AND pregunta_id = :pregunta_id");
        return $stmt->execute($datos);
    }

    public static function restarMismaPregunta($datos){
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE preguntas SET misma_pregunta = misma_pregunta - 1 WHERE id = :pregunta_id");
        $stmt->execute($datos);
    }

    public static function deleteAll() {
        
    }
}