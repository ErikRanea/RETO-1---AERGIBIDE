<?php
class Publicacion {
    private $connection;

    public function __construct() {
        $this->getConnection();
    }

    public function getConnection() {
        $dbObj = new Db();
        $this->connection = $dbObj->connection;
    }

    // Método para obtener las últimas 5 publicaciones (preguntas y respuestas)
    public function getPubliaciones() {
        $sql = "
            (SELECT 'pregunta' as tipo, p.titulo, p.texto, p.fecha_hora, u.foto_perfil 
             FROM Preguntas p
             JOIN Usuarios u ON p.id_usuario = u.id)
            UNION
            (SELECT 'respuesta' as tipo, pr.titulo, r.texto, r.fecha_hora, u.foto_perfil 
             FROM Respuestas r
             JOIN Preguntas pr ON r.id_pregunta = pr.id
             JOIN Usuarios u ON r.id_usuario = u.id)
            ORDER BY fecha_hora DESC
            LIMIT 5;


        ";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Devolver los resultados como array asociativo
    }

    // Método para obtener preguntas por tema (sin cambios)
    public function getPublicacionesByTemaId($tema_id) {
        $sql = "SELECT * FROM Preguntas WHERE id_tema = :tema_id";  // Filtrar preguntas por el tema
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':tema_id', $tema_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

