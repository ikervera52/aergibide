<?php
require_once __DIR__ . '/Database.php';

class UsuarioModel {
    
    public static function getAll() {
        
    }
    
    public static function getUserById($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT 
                                us.id, us.nombre, us.tipo, us.email, us.datetime, us.foto_perfil_id,
                                fp.ruta_archivo
                            FROM usuarios us
                            LEFT JOIN foto_perfil_usuarios fp ON us.foto_perfil_id = fp.id
                            WHERE us.id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function getUserByEmail($email) {
        $data = ['email' => $email];
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id, nombre, tipo, email, contrasena, datetime FROM usuarios WHERE email = :email");
        $stmt->execute($data);
        return $stmt->fetch();     
    }
    public static function emailEnUso($email, $idExcluir) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = :email AND id != :id");
        $stmt->execute(['email' => $email, 'id' => $idExcluir]);
        return $stmt->fetch() !== false;
    }

    public static function updateDatos($id, $nombre, $email) {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id");
        $stmt->execute(['nombre' => $nombre, 'email' => $email, 'id' => $id]);
    }

    public static function createFoto($datos) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO foto_perfil_usuarios (nombre, ruta_archivo, mime_tipo, tamano)
                            VALUES (:nombre, :ruta_archivo, :mime_tipo, :tamano)");
        $stmt->execute($datos);
        return $db->lastInsertId();
    }

    public static function setFoto($usuarioId, $fotoId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE usuarios SET foto_perfil_id = :foto WHERE id = :id");
        $stmt->execute(['foto' => $fotoId, 'id' => $usuarioId]);
    }

    public static function deleteFotoById($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM foto_perfil_usuarios WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}