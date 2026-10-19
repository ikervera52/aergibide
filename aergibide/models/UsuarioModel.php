<?php
require_once __DIR__ . '/Database.php';

class UsuarioModel {
    
    public static function getAll() {
        
    }
    
    public static function getById($id) {
        
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