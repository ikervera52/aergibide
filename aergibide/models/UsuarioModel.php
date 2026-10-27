<?php
require_once __DIR__ . '/Database.php';

class UsuarioModel {
    
    public static function getAll() {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id, nombre, email, tipo
                              FROM usuarios");
        $stmt -> execute();

        $resultado = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        return $resultado;
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
    public static function create(array $usuario) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO usuarios
                              (nombre, tipo, email, contrasena)
                              VALUES (:nombre, :tipo, :email, :password)");
        $stmt -> execute($usuario);                      
    }
    
    public static function deleteById($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->execute($id);
    }
    
    public static function deleteAll() {
        
    }

    public static function update($datos){
        $db = Database::getConnection();
        
        if ($datos["password"] === "") {
        // Sin contraseña nueva: se mantiene la actual
        $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, tipo = :tipo WHERE id = :id";
        $params = [
            ":nombre" => $datos["nombre"],
            ":email"  => $datos["email"],
            ":tipo"   => $datos["tipo"],
            ":id"     => $datos["id"]
        ];
        } else {
        $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, tipo = :tipo, contrasena = :password WHERE id = :id";   
        $params = [
            ":nombre"   => $datos["nombre"],
            ":email"    => $datos["email"],
            ":tipo"     => $datos["tipo"],
            ":password" => $datos["password"],
            ":id"       => $datos["id"]
        ];
        }

        $db->prepare($sql)->execute($params);
    }
}