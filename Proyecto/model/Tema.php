<?php
class Tema {
    private $tabla = "Temas";
    private $connection;

    public function __construct() {
        $this->getConnection();
    }

    public function getConnection() {
        $dbObj = new db();
        $this->connection = $dbObj->conection;
    }

    // Método para obtener los temas
    public function getTemas() {
        $sql = "SELECT * FROM " . $this->tabla;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
