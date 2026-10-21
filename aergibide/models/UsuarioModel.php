<?php
require_once __DIR__ . '/Database.php';

class UsuarioModel {
    
    public static function getAll() {
        
    }
    
    public static function getUserById($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT 
                                us.id, us.nombre, us.tipo, us.email, us.datetime,
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
    
    public static function create($datos) {
        
    }
    
    public static function deleteById($id) {
        
    }
    
    public static function deleteAll() {
        
    }
}