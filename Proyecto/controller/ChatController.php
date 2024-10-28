<?php
require_once __DIR__ . '/../model/Chat.php';

class ChatController {
    public $view = "chat/view";

    public function __construct() {
        // Se puede agregar lógica de inicialización aquí si es necesario
    }

    public function enviarMensaje() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $chat = new Chat();
            $emisor = $_SESSION['user_data']['id'];
            $receptor = $_POST['receptor'];
            $mensaje = $_POST['mensaje'];
            $chat->enviarMensaje($emisor, $receptor, $mensaje);
            echo json_encode(['success' => true]);
        }
    }

    public function obtenerMensajes() {
        $chat = new Chat();
        $id_usuario = $_SESSION['user_data']['id'];
        $receptor = $_GET['receptor']; // Suponiendo que se pasa el ID del receptor
        $mensajes = $chat->obtenerMensajes($id_usuario, $receptor);
        echo json_encode($mensajes);
    }
}
