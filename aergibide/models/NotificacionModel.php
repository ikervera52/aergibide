<?php
require_once __DIR__ . '/Database.php';

class NotificacionModel {

    public static function getByUsuarioId($id) {
        $db = Database::getConnection();
        $query = $db->prepare("SELECT 
                                    n.id,
                                    n.pregunta_id,
                                    us.nombre,
                                    pr.titulo,
                                    re.contenido
                                FROM notificaciones n
                                INNER JOIN usuarios us ON n.usuario_id_r = us.id
                                INNER JOIN preguntas pr ON n.pregunta_id = pr.id
                                LEFT JOIN respuestas re ON re.id = (
                                    SELECT MAX(id)
                                    FROM respuestas
                                    WHERE pregunta_id = n.pregunta_id
                                      AND usuario_id = n.usuario_id_r
                                )
                                WHERE n.usuario_id_p = :id
                                ORDER BY n.id DESC");
        $query->execute(['id' => $id]);
        return $query->fetchAll();
    }

    public static function deleteById($id, $usuarioId) {
        $db = Database::getConnection();
        $query = $db->prepare("DELETE FROM notificaciones 
                               WHERE id = :id AND usuario_id_p = :usuario_id");
        return $query->execute(['id' => $id, 'usuario_id' => $usuarioId]);
    }
}