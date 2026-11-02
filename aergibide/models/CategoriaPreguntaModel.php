<?php
require_once __DIR__ . '/Database.php';

class CategoriaPreguntaModel {

    public static function getAll() {
        $db = Database::getConnection();
        $query = $db->prepare("SELECT id, nombre, slug FROM categorias_preguntas");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}