<?php
session_start();
require_once "../model/Chat.php"; // Asegúrate de que la ruta sea correcta

header('Content-Type: application/json'); // Asegúrate de establecer el tipo de contenido

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id_emisor = $_GET['id_emisor'];
    $id_receptor = $_GET['id_receptor'];

    // Aquí deberías tener la lógica para obtener los mensajes
    $chatModel = new Chat();
    $messages = $chatModel->obtenerMensajes($id_emisor, $id_receptor);

    echo json_encode($messages); // Asegúrate de que esto devuelva un JSON válido
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido.']);
}
?>
