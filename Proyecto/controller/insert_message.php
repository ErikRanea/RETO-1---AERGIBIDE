<?php
session_start();
require_once "../model/Chat.php"; // Asegúrate de que la ruta sea correcta

header('Content-Type: application/json'); // Asegúrate de establecer el tipo de contenido

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_emisor = $_POST['id_emisor'];
    $id_receptor = $_POST['id_receptor'];
    $mensaje = $_POST['mensaje'];

    // Aquí deberías tener la lógica para insertar el mensaje en la base de datos
    $chatModel = new Chat();
    $success = $chatModel->guardarMensaje($id_emisor, $id_receptor, $mensaje);

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se pudo enviar el mensaje.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido.']);
}
?>
