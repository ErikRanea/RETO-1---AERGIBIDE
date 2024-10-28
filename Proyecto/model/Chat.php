<?php
require_once __DIR__ . '/../model/db.php';

class Chat {
    private $db;

    public function __construct() {
        $this->db = new Db();
    }

    public function enviarMensaje($emisor, $receptor, $mensaje) {
        $stmt = $this->db->connection->prepare("INSERT INTO Mensajes (id_emisor, id_receptor, mensaje) VALUES (?, ?, ?)");
        $stmt->execute([$emisor, $receptor, $mensaje]);
        return $this->db->connection->lastInsertId();
    }

    public function obtenerMensajes($id_usuario1, $id_usuario2) {
        $stmt = $this->db->connection->prepare("SELECT * FROM Mensajes WHERE (id_emisor = ? AND id_receptor = ?) OR (id_emisor = ? AND id_receptor = ?) ORDER BY fecha ASC");
        $stmt->execute([$id_usuario1, $id_usuario2, $id_usuario2, $id_usuario1]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
