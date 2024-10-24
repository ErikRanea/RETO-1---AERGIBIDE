<?php
class Tema {
    private $table = "Temas";
    private $connection;

    public function __construct() {
        $this->getConnection();
    }

    public function getConnection() {
        $dbObj = new Db();
        $this->connection = $dbObj->connection;
    }

    // Método para obtener todos los temas
    public function getTemas() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTemaById($id) {
        $sql = "SELECT * FROM " . $this->table. " where id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
