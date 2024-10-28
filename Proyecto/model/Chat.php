<?php
require_once 'Db.php';

class Chat {
    private $connection;

    public function __construct() {
        $this->getConnection();
    }

    public function getConnection() {
        $dbObj = new Db();
        $this->connection = $dbObj->connection;
    }

    public function getUsuariosChat() {
        $sql = "SELECT id, username FROM Usuarios";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function enviarMensaje($emisorId, $receptorId, $mensaje) {
        $sql = "INSERT INTO Mensajes (id_emisor, id_receptor, mensaje) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$emisorId, $receptorId, $mensaje]);
    }

    public function insertMessage($id_emisor, $id_receptor, $mensaje) {
        $query = "INSERT INTO Mensajes (id_emisor, id_receptor, mensaje) VALUES (:id_emisor, :id_receptor, :mensaje)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id_emisor', $id_emisor);
        $stmt->bindParam(':id_receptor', $id_receptor);
        $stmt->bindParam(':mensaje', $mensaje);
        $stmt->execute();
    }

    public function getMessages($id_emisor, $id_receptor) {
        $query = "SELECT * FROM Mensajes WHERE (id_emisor = :id_emisor AND id_receptor = :id_receptor) OR (id_emisor = :id_receptor AND id_receptor = :id_emisor) ORDER BY fecha";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id_emisor', $id_emisor);
        $stmt->bindParam(':id_receptor', $id_receptor);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}